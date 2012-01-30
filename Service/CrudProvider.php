<?php
namespace BrowserCreative\CrudBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use BrowserCreative\CrudBundle\Entity\CrudItem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class CrudProvider {
    /**
     * @var ContainerInteface $container
     */
    protected $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function moveFile(CrudItem $item, UploadedFile $file, $fileProperty = 'imagePath')
    {
        $desinationFolder = $this->container->getParameter('kernel.root_dir') . '/../web/' .$this->container->getParameter('site.uploadfolder');
        $filename = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.\/_|+ -]/", '', $file->getClientOriginalName());

        $file->move($desinationFolder, $filename);

        $fileSetter = 'set' . ucfirst($fileProperty);
        $item->$fileSetter($filename);
    }
}