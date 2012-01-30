<?php
namespace Hub\NewsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class CrudProvider {
    /**
     * @var ContainerInteface $container
     */
    protected $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}