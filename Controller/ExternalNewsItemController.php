<?php

namespace Hub\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \UnexpectedValueException;

class ExternalNewsItemController extends Controller
{
    public function homepageAction()
    {
        $memcachedManager = $this->get('synth_memcached');
        $memcachedKey = 'ExternalNews_homepage';
        if (!$output = $memcachedManager->get($memcachedKey) && $this->get('doctrine.orm.entity_manager')) {

            try {
               $octaviaHousingNews = $this->get('externalNews.provider')->getOctaviaHousingNews();
            } catch (UnexpectedValueException $exception) {
                $octaviaHousingNews = false;
            }

            $output = $this->render('HubNewsBundle:ExternalNewsItem:homepage.html.twig', array(
                'octaviaHousingNews' => $octaviaHousingNews
            ));

            if($octaviaHousingNews) {
                $memcachedManager->set($memcachedKey, $output, "ExternalNews", 3600);
            }
        }

        return $output;
    }
}