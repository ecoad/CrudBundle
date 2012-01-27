<?php
namespace Hub\NewsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \UnexpectedValueException;

class ExternalNewsProvider {
    /**
     * @var ContainerInteface $container
     */
    protected $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Retrieve news from Octavia Housing
     * 
     * @throws UnexpectedValueException
     * @return array
     */
    public function getOctaviaHousingNews()
    {
        try {
            $externalNewsResponse = file_get_contents(
                $this->container->getParameter('news_external_octaviahousing_location'));

            if (!$externalNews = json_decode($externalNewsResponse)) {
                throw new UnexpectedValueException('Unable to decode response');
            }
        } catch(\Exception $e) {
            throw new UnexpectedValueException('Octavia Housing feed unavailable');
        }

        return $externalNews;
    }
}