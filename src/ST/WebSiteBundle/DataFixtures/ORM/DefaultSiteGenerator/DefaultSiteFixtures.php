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

        $this->createTranslations();
        $this->createHomePage();
        $this->createDashboard();
    }

    /**
     * Create the dashboardSponsorPage
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
    }
    
    /**
     * Insert all translations
     */
    private function createTranslations()
    {
        // SplashPage
        $trans['lang_chooser.welcome']['en'] = 'Welcome, continue in English';
        $trans['lang_chooser.welcome']['fr'] = 'Bienvenu, continuer en Français';


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
