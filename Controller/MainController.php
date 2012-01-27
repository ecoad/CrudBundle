<?php

namespace Hub\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \UnexpectedValueException;

class MainController extends Controller
{
    public function indexAction()
    {
        $latestInternalNews = $this->get('doctrine.orm.entity_manager')->getRepository('HubNewsBundle:InternalNewsItem')
            ->getLatestActiveNewsItemsQueryBuilder();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $latestInternalNews->getQuery(),
            $this->get('request')->query->get('page', 1),
            20
        );

        try {
            $memcachedManager = $this->get('synth_memcached');
            if (!$octaviaHousingNews = $memcachedManager->get("ExternalNews_index")) {

                $octaviaHousingNews = $this->get('externalNews.provider')->getOctaviaHousingNews();

                $memcachedManager->set("ExternalNews_index", $octaviaHousingNews, "ExternalNews", 7200);
            }

        } catch (UnexpectedValueException $exception) {
            $octaviaHousingNews = false;
        }

        return $this->render('HubNewsBundle:Main:index.html.twig', array(
            'internalNews' => $pagination,
            'octaviaHousingNews' => $octaviaHousingNews
        ));
    }
}
