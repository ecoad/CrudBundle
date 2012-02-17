<?php
namespace BrowserCreative\CrudBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Hub\UserBundle\Entity\User;
use BrowserCreative\CrudBundle\Entity\CrudItem;
use Doctrine\Common\Persistence\ObjectManager;

class LoadNewsData implements FixtureInterface, ContainerAwareInterface {
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userProvider = $this->container->get('user.provider');
        $user = $userProvider->loadUserByUsername('Elliot Coad');

        for ($i = 0; $i < 30; $i++) {
            $item = new CrudItem();
            $item->setSubject('This is a news item!');
            $item->setBody('<p>
Aliquam erat volutpat. Nam at tortor est, sed mattis leo. Etiam dolor est, consequat at tristique eget, aliquet vitae turpis. In vitae ante in orci dictum lacinia. Nulla consectetur consequat semper. Integer libero nisi, molestie pretium gravida ut, venenatis at ante. Vestibulum fringilla cursus est non iaculis. Nullam ultricies dui ac ligula suscipit consequat. Nullam auctor magna ac massa tincidunt dignissim ac nec arcu. Pellentesque nec nulla eget libero bibendum ultricies quis ac enim. Aenean convallis pharetra tellus dictum volutpat. Vivamus vitae orci neque. Aliquam in quam turpis.
</p>
<p>
Mauris eu purus est. Etiam volutpat pulvinar risus sit amet ultricies. Integer risus tortor, molestie non consequat sit amet, blandit non eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque quis ipsum augue. Nullam nec est id velit volutpat pharetra vitae congue ante. Sed felis orci, cursus sollicitudin imperdiet ornare, lacinia dapibus magna. Mauris dapibus tincidunt tincidunt. Cras turpis lorem, tincidunt in porttitor ac, facilisis sit amet diam. Donec accumsan tristique fermentum. Sed id consequat est. Nulla ut ligula in nisi auctor pretium. Praesent rhoncus ipsum vitae quam ultrices accumsan. Integer et tellus vel diam adipiscing faucibus non at massa. Integer porttitor rutrum felis sit amet bibendum. Vivamus eget sapien eget elit bibendum cursus vehicula volutpat ante.
</p>');
            $item->setActive(true);
            $item->setAuthor($user);

            $manager->persist($item);
        }

        $manager->flush();
    }
}