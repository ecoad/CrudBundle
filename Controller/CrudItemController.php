<?php

namespace BrowserCreative\CrudBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use BrowserCreative\CrudBundle\Entity\CrudItem;
use BrowserCreative\CrudBundle\Form\Type\CrudItemType;

class CrudItemController extends Controller
{
    public function indexAction()
    {
        $items = $this->get('doctrine.orm.entity_manager')->getRepository('BrowserCreativeCrudBundle:CrudItem')
            ->getLatestActiveItems();

        $paginator = $this->get('knp_paginator');
        $pageLength = 20;
        $paginationItems = $paginator->paginate($items, $this->getRequest()->get('page', 1), $pageLength);

        return $this->render('BrowserCreativeCrudBundle:CrudItem:index.html.twig', array(
            'items' => $paginationItems
        ));
    }

    public function viewAction($itemId)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository('BrowserCreativeCrudBundle:CrudItem');

        if (!$item = $repository->findOneById($itemId)) {
            throw new NotFoundHttpException('Item not found');
        }

        return $this->render('BrowserCreativeCrudBundle:CrudItem:view.html.twig', array(
            'item' => $item
        ));
    }

    /**
     * Edit or create an item
     * 
     * @param  integer $itemId
     * @return mixed RedirectResponse or Render
     */
    public function updateAction($itemId = null)
    {
        if (!$user = $this->container->get('security.context')->getToken()->getUser()) {
            throw new AuthenticationException('User must be logged in');
        }

        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository('BrowserCreativeCrudBundle:CrudItem');

        if ($itemId) {
            if (!$item = $repository->findOneById($itemId)) {
                throw new NotFoundHttpException('Item not found');
            }
        } else {
            $item = new CrudItem();
            $item->setAuthor($user);
        }

        $formBuilder = $this->createFormBuilder($item)
            ->add('body', 'textarea', array('error_bubbling' => true))
            ->add('subject', 'text', array('error_bubbling' => true))
            ->add('visible', 'checkbox', array('error_bubbling' => false, 'required' => false));
        $form = $formBuilder->getForm();

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $entityManager->persist($item);
                $entityManager->flush();
            }

            return $this->redirect($this->generateUrl('BrowserCreativeCrudBundle_CrudItem_view', array(
                    'itemId' => $item->getId(), 
                    'itemSubject' => $this->get('site.twig.extension')->urlSlugify($item->getSubject()
                )))
            );
        }

        return $this->render('BrowserCreativeCrudBundle:CrudItem:update.html.twig', array(
            'form' => $form->createView(),
            'item' => $item
        ));
    }

    public function deleteAction($itemId)
    {
        if (!$user = $this->container->get('security.context')->getToken()->getUser()) {
            throw new AuthenticationException('User must be logged in to delete news item');
        }

        if (!$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AuthenticationException('User is not authorised to delete');
        }

        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository('BrowserCreativeCrudBundle:CrudItem');

        if (!$item = $repository->findOneById($itemId)) {
            throw new NotFoundHttpException('News Item not found');
        }

        $entityManager->remove($item);

        $url = $this->generateUrl(
            $this->getRequest()->get('returnRoute'), $this->getRequest()->get('returnRouteParams', array()));

        return $this->redirect($url);
    }
}