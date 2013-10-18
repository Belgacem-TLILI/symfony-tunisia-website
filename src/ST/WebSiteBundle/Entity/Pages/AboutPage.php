<?php

namespace ST\WebSiteBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;

/**
 * AboutPage
 *
 * @ORM\Table(name="st_about_page")
 * @ORM\Entity
 */
class AboutPage extends \Kunstmaan\NodeBundle\Entity\AbstractPage implements \Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface
{


    /**
     * Returns the default backend form type for this page
     *
     * @return \ST\WebSiteBundle\Form\Pages\AboutPageAdminType
     */
    public function getDefaultAdminType()
    {
        return new \ST\WebSiteBundle\Form\Pages\AboutPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array(
            array(
                'name' => 'AboutPage',
                'class'=> 'ST\WebSiteBundle\Entity\Pages\AboutPage'
            )
        );
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array(
            "STWebSiteBundle:main",
            "STWebSiteBundle:left-sidebar",
            "STWebSiteBundle:right-sidebar",
            "STWebSiteBundle:footer",
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array("STWebSiteBundle:contentpage");
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return "STWebSiteBundle:Pages:Common/view.html.twig";
    }
}