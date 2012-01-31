# CrudBundle

Do your bundles start life with the following?:

*    Entity attributes with getters and setters for Id, Title, Body, DateCreated, Author(User), LastModified, Image. 
*    Controllers and views that create, read, update and destroy.
*    Basic validation
*    A service provider class for your bundle, including updating the services.yml

If you answered yes... then stop re-writing everything over and over! Start your bundle's life with the CrudBundle

## Requirements
*    Symfony 2 (tested with versions 2.0.3 >= 2.0.9
*    KnpPaginator (low dependency, minor refactory)
*    AvalancheImagineBundle (low dependency, minor refactor)

## Installation
*    Download the zip file, extract in to your src bundles folder, and perform a search and replace on CrudBundle with the name of your new Bundle
*    Coming soon: Command line installation

### Setup
* e.g. new bundle is named Gallery and namespace is Hub
* Copy CrudBundle to src/Hub/GalleryBundle
* Rename these files:

    BrowserCreativeCrudBundle.php => HubGalleryBundle.php
    Controller/CrudItemController.php => Controller/GalleryItemController.php
    DataFixtures/ORM/CrudData.php => DataFixtures/ORM/GalleryData.php
    DependencyInjection/BrowserCreativeCrudExtension.php => DependencyInjection/HubGalleryExtension.php
    Entity/CrudItem.php => Entity/GalleryItem.php
    Entity/CrudItemRepository.php => Entity/GalleryItemRepository.php
    Form/Type/CrudItemType.php => Form/Type/GalleryItemType.php
    Resources/views/CrudItem => Resources/views/GalleryItem
    Service/CrudProvider.php => Service/GalleryProvider.php

* Delete .gitignore
* Search and replace in file:

    crud => gallery
    Crud => Gallery
    BrowserCreative => Hub
    browsercreative => hub

* Register your new bundle:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Hub\GalleryBundle\HubGalleryBundle(),
        );
    }