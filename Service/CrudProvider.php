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

        //TODO: Filename sanitise
        //TODO: Hash folder

        // move takes the target directory and then the target filename to move to
        // ls
        $file->move($this->container->getParameter('kernel.root_dir') . '/../web/' .$this->container->getParameter('site.uploadfolder'), 
            $file->getClientOriginalName());

        //$fileSetter = 'set' . ucfirst($fileProperty);

        //$item->$fileSetter($file->getClientOriginalName());
        $item->image_path = $file->getClientOriginalName();

        $file = null;
    }
}