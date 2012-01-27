<?php

namespace Hub\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Hub\NewsItem\Entity\InternalNewsItem;
use Hub\NewsItem\Form\Type\InternalNewsItemType;

class InternalNewsItemController extends Controller
{
    public function viewAction($newsItemId)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository('HubNewsBundle:InternalNewsItem');

        if (!$newsItem = $repository->findOneById($newsItemId)) {
            throw new NotFoundHttpException('News Item not found');
        }

        return $this->render('HubNewsBundle:InternalNewsItem:view.html.twig', array(
            'newsItem' => $newsItem
        ));
    }

    public function homepageAction()
    {
        $memcachedManager = $this->get('synth_memcached');
        $memcachedKey = 'InternalNews_homepage';
        if (!$output = $memcachedManager->get($memcachedKey)) {

            $latestInternalNews = $this->get('doctrine.orm.entity_manager')->getRepository('HubNewsBundle:InternalNewsItem')
                ->getLatestActiveNewsItemsQueryBuilder();

            $paginator = $this->get('knp_paginator');
            $internalNewsItems = $paginator->paginate($latestInternalNews->getQuery(), 1, 3);

            $output = $this->render('HubNewsBundle:InternalNewsItem:homepage.html.twig', array(
                'internalNewsItems' => $internalNewsItems
            ));

            $memcachedManager->set($memcachedKey, $output, "InternalNews", 3600);
        }

        return $output;
    }

    public function updateAction($newsItemId = null)
    {
        if (!$user = $this->container->get('security.context')->getToken()->getUser()) {
            throw new AuthenticationException('User must be logged in to reply');
        }

        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository('HubNewsBundle:InternalNewsItem');

        if ($newsItemId) {
            if (!$newsItem = $repository->findOneById($newsItemId)) {
                throw new NotFoundHttpException('News Item not found');
            }
        } else {
            $newsItem = new InternalNewsItem();
            $newsItem->setAuthor($user);
        }

        $formBuilder = $this->createFormBuilder($newsItem)
            ->add('body', 'textarea', array('error_bubbling' => true))
            ->add('subject', 'text', array('error_bubbling' => true))
            ->add('visible', 'checkbox', array('error_bubbling' => false, 'required' => false));
        $form = $formBuilder->getForm();

        if ($this->getRequest()->getMethod() == strtoupper('post')) {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $entityManager->persist($newsItem);
                $entityManager->flush();
            }

            return $this->redirect($this->generateUrl('HubNewsBundle_internalnewsitem_view',
                array(
                    'newsItemId' => $newsItem->getId(),
                    'newsItemSubject' => $this->get('site.twig.extension')->urlSlugify($newsItem->getSubject())
                ))
            );
        }

        return $this->render('HubNewsBundle:InternalNewsItem:update.html.twig', array(
            'form' => $form->createView(),
            'newsItem' => $newsItem
        ));
    }

    public function deleteAction($newsItemId)
    {
        if (!$user = $this->container->get('security.context')->getToken()->getUser()) {
            throw new AuthenticationException('User must be logged in to delete news item');
        }

        if (!$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AuthenticationException('User is not authorised to delete');
        }

        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository('HubNewsBundle:InternalNewsItem');

        if (!$newsItem = $repository->findOneById($newsItemId)) {
            throw new NotFoundHttpException('News Item not found');
        }

        $entityManager->remove($newsItem);

        $url = $this->generateUrl(
            $this->getRequest()->get('returnRoute'), $this->getRequest()->get('returnRouteParams', array()));

        return $this->redirect($url);
    }
}