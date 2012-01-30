<?php
namespace BrowserCreative\CrudBundle\Service;

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