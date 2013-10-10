<?php

namespace ST\WebSiteBundle\DataFixtures\ORM\DefaultSiteGenerator;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Kunstmaan\AdminBundle\Entity\DashboardConfiguration;
use Kunstmaan\MediaBundle\Entity\Media;
use Kunstmaan\MediaBundle\Helper\RemoteVideo\RemoteVideoHelper;
use Kunstmaan\MediaBundle\Helper\Services\MediaCreatorService;
use Kunstmaan\NodeBundle\Helper\Services\PageCreatorService;
use Kunstmaan\PagePartBundle\Helper\Services\PagePartCreatorService;
use Kunstmaan\TranslatorBundle\Entity\Translation;

use ST\WebSiteBundle\Entity\Pages\ContentPage;
use ST\WebSiteBundle\Entity\Pages\HomePage;

/**
 * DefaultSiteFixtures
 */
class DefaultSiteFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * Username that is used for creating pages
     */
    const ADMIN_USERNAME = 'Admin';

    /**
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var PageCreatorService
     */
    private $pageCreator;

    /**
     * @var PagePartCreatorService
     */
    private $pagePartCreator;

    /**
     * @var MediaCreatorService
     */
    private $mediaCreator;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->pageCreator = $this->container->get('kunstmaan_node.page_creator_service');
        $this->pagePartCreator = $this->container->get('kunstmaan_pageparts.pagepart_creator_service');
        $this->mediaCreator = $this->container->get('kunstmaan_media.media_creator_service');

        $this->createTranslations();
        $this->createMedia();
        $this->createHomePage();
        $this->createContentPages();
        $this->createDashboard();
    }

    /**
     * Create the dashboard
     */
    private function createDashboard()
    {
        /** @var $dashboard DashboardConfiguration */
        $dashboard = $this->manager->getRepository("KunstmaanAdminBundle:DashboardConfiguration")->findOneBy(array());
        if (is_null($dashboard)) {
            $dashboard = new DashboardConfiguration();
        }
        $dashboard->setTitle("Dashboard");
        $dashboard->setContent('<div class="alert alert-info"><strong>Important: </strong>please change these items to the graphs of your own site!</div><iframe src="https://rpm.newrelic.com/public/charts/jjPIEE7OHz9" width="100%" height="300" scrolling="no" frameborder="no"></iframe><iframe src="https://rpm.newrelic.com/public/charts/hmDWR0eUNTo" width="100%" height="300" scrolling="no" frameborder="no"></iframe><iframe src="https://rpm.newrelic.com/public/charts/fv7IP1EmbVi" width="100%" height="300" scrolling="no" frameborder="no"></iframe>');
        $this->manager->persist($dashboard);
        $this->manager->flush();
    }

    /**
     * Create a Homepage
     */
    private function createHomePage()
    {
        $homePage = new HomePage();
        $homePage->setTitle('Home');

        $translations = array();
        $translations[] = array('language' => 'en', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Home');
            $translation->setSlug('');
        });
        $translations[] = array('language' => 'fr', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Home');
            $translation->setSlug('');
        });

        $options = array(
            'parent' => null,
            'page_internal_name' => 'homepage',
            'set_online' => true,
            'hidden_from_nav' => false,
            'creator' => self::ADMIN_USERNAME
        );

        $this->pageCreator->createPage($homePage, $translations, $options);

        $pageparts = array();
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'First column heading',
                'setNiv'   => 1
            )
        );
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
            )
        );
        $pageparts['middle_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Second column heading',
                'setNiv'   => 1
            )
        );
        $pageparts['middle_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.'
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Third column heading',
                'setNiv'   => 1
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('homepage', $pageparts, 'en');

        $pageparts = array();
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Eerste title',
                'setNiv'   => 1
            )
        );
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de standaard proeftekst in deze bedrijfstak sinds de 16e eeuw, toen een onbekende drukker een zethaak met letters nam en ze door elkaar husselde om een font-catalogus te maken.'
            )
        );
        $pageparts['middle_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Tweede title',
                'setNiv'   => 1
            )
        );
        $pageparts['middle_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'Er zijn vele variaties van passages van Lorem Ipsum beschikbaar maar het merendeel heeft te lijden gehad van wijzigingen in een of andere vorm, door ingevoegde humor of willekeurig gekozen woorden die nog niet half geloofwaardig ogen.'
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Derde titel',
                'setNiv'   => 1
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'Het standaard stuk van Lorum Ipsum wat sinds de 16e eeuw wordt gebruikt is hieronder, voor wie er interesse in heeft, weergegeven. Secties 1.10.32 en 1.10.33 van "de Finibus Bonorum et Malorum" door Cicero zijn ook weergegeven in hun exacte originele vorm, vergezeld van engelse versies van de 1914 vertaling door H. Rackham.'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('homepage', $pageparts, 'nl');
    }

    /**
     * Create a ContentPage
     */
    private function createContentPages()
    {
        $nodeRepo = $this->manager->getRepository('KunstmaanNodeBundle:Node');
        $homePage = $nodeRepo->findOneBy(array('internalName' => 'homepage'));

        $contentPage = new ContentPage();
        $contentPage->setTitle('Satellite');

        $translations = array();
        $translations[] = array('language' => 'en', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Satellite');
            $translation->setSlug('satellite');
            $translation->setWeight(20);
        });
        $translations[] = array('language' => 'nl', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Satelliet');
            $translation->setSlug('satelliet');
            $translation->setWeight(20);
        });

        $options = array(
            'parent' => $homePage,
            'page_internal_name' => 'satellite',
            'set_online' => true,
            'hidden_from_nav' => false,
            'creator' => self::ADMIN_USERNAME
        );

        $this->pageCreator->createPage($contentPage, $translations, $options);

        // Add pageparts
        $pageparts = array();
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Satellite (artificial)',
                'setNiv'   => 1
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => '<p>A <b>satellite</b> is an object that orbits another object. In space, satellites may be made by man, or they may be natural. The moon is a natural satellite that orbits the Earth. Most man-made satellites also orbit the Earth, but some orbit other planets, such as Saturn, Venus or Mars, or the moon.</p>'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('satellite', $pageparts, 'en');

        $pageparts = array();
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Kunstmaan (satelliet)',
                'setNiv'   => 1
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => '<p>Een <b>kunstmaan</b> of <b>satelliet</b> is een door mensen gemaakt object in een baan om een hemellichaam. Kunstmanen zijn onbemande toestellen die door de mens in een baan zijn gebracht. Natuurlijke manen zijn meestal objecten met de structuur van een kleine planeet of planetoïde die door de zwaartekracht van de planeet in hun baan worden gehouden.</p>'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('satellite', $pageparts, 'nl');
    }


    /**
     * Insert all translations
     */
    private function createTranslations()
    {
        // SplashPage
        $trans['lang_chooser.welcome']['en'] = 'Welcome, continue in English';
        $trans['lang_chooser.welcome']['fr'] = 'Bienvenu, continuer en Français';
        $trans['lang_chooser.welcome']['nl'] = 'Welkom, ga verder in het Nederlands';
        $trans['lang_chooser.welcome']['de'] = 'Willkommen, gehe weiter in Deutsch';

        foreach ($trans as $key => $array) {
            foreach ($array as $lang => $value) {
                $t = new Translation;
                $t->setKeyword($key);
                $t->setLocale($lang);
                $t->setText($value);
                $t->setDomain('messages');
                $t->setCreatedAt(new \DateTime());
                $t->setFlag(Translation::FLAG_NEW);

                $this->manager->persist($t);
            }
        }

        $this->manager->flush();
    }

    /**
     * Create some dummy media files
     */
    private function createMedia()
    {
        // Add images to database
        $imageFolder = $this->manager->getRepository('KunstmaanMediaBundle:Folder')->findOneBy(array('rel' => 'image'));
        $filesFolder = $this->manager->getRepository('KunstmaanMediaBundle:Folder')->findOneBy(array('rel' => 'files'));
        $publicDir = dirname(__FILE__).'/../../../Resources/public/';
        $this->mediaCreator->createFile($publicDir.'img/general/logo.png', $imageFolder->getId(), MediaCreatorService::CONTEXT_CONSOLE);
        $this->mediaCreator->createFile($publicDir.'files/dummy/sample.pdf', $filesFolder->getId(), MediaCreatorService::CONTEXT_CONSOLE);

        // Create dummy video folder and add dummy videos
        {
            $videoFolder = $this->manager->getRepository('KunstmaanMediaBundle:Folder')->findOneBy(array('rel' => 'video'));
            $this->createVideoFile('Kunstmaan', 'WPx-Oe2WrUE', $videoFolder);
        }
    }

    /**
     * Create a video file record in the database.
     *
     * @param $name
     * @param $code
     * @param $folder
     * @return Media
     */
    private function createVideoFile($name, $code, $folder)
    {
        // Hack for media bundle issue
        $dir = dirname($this->container->get('kernel')->getRootDir());
        chdir($dir . '/web');
        $media = new Media();
        $media->setFolder($folder);
        $media->setName($name);
        $helper = new RemoteVideoHelper($media);
        $helper->setCode($code);
        $helper->setType('youtube');
        $this->manager->getRepository('KunstmaanMediaBundle:Media')->save($media);
        chdir($dir);

        return $media;
    }

    /**
     * Get the order of this fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 51;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
