<?php
namespace Hub\NewsBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Hub\UserBundle\Entity\User;
use Hub\NewsBundle\Entity\CrudItem;

class LoadNewsData implements FixtureInterface, ContainerAwareInterface {
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load($manager)
    {
        $this->loadInternalNews($manager);
    }

    public function loadInternalNews($manager)
    {
        $userProvider = $this->container->get('user.provider');
        $user = $userProvider->loadUserByUsername('elliotcoad');

        for ($i = 0; $i < 20; $i++) {
            $internalNewsItem = new CrudItem();
            $internalNewsItem->setSubject('Octavia Launches The Hub!');
            $internalNewsItem->setBody('<p>Octavia Housing have been shortlisted to win an award for the &lsquo;Most Innovative Community Engagement&rsquo; programme.</p>
    <p>The award, run by <a href="http://www.housingexcellence.co.uk/">Housing Excellence</a>, recognises social housing providers and community groups who put residents at the heart of everything they do. Octavia operates a large and inventive resident involvement programme as well as a number of wider-reaching community liaison schemes through their related charity, the Octavia Foundation.</p>
    <p>Andy Carlisle, Resident Involvment Manager at Octavia said: &ldquo;We are really pleased to be shortlisted, resident involvement is central to the culture at Octavia and is key to achieving our aim of &lsquo;being an organisation that residents really value&rsquo;. We engage with residents to get their feedback in a variety of ways because we recognise that one size does not fit all and people want to give their feedback and work with us in different ways.&rdquo;</p>
    <p>Octavia have displayed commitment to valuable resident engagement by developing a strategy for involving residents and other members of the community, and this has resulted in many successes, including increasing the number of younger people involved, creating new community based activities through work with the Octavia Foundation and involving residents in setting our business priorities.</p>
    <p>The winners will be announced by a panel of independent judges on 1 March.</p>
    <p>Visit the links here to find out more about <a href="http://octaviahousing.org.uk/residents/be-involved/">resident involvement opportunities at Octavia Housing </a>or community project with the <a href="http://www.octaviafoundation.org.uk">Octavia Foundation</a>.</p>
    ');
            $internalNewsItem->setVisible(true);
            $internalNewsItem->setAuthor($user);

            $manager->persist($internalNewsItem);
        }


        $manager->flush();
    }
}