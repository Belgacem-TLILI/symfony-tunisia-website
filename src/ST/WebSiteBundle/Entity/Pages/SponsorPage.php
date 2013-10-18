<?php

namespace ST\WebSiteBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;

/**
 * SponsorPage
 *
 * @ORM\Table(name="st_sponsor_page")
 * @ORM\Entity
 */
class SponsorPage extends \Kunstmaan\NodeBundle\Entity\AbstractPage implements \Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface
{


    /**
     * Returns the default backend form type for this page
     *
     * @return \ST\WebSiteBundle\Form\Pages\SponsorPageAdminType
     */
    public function getDefaultAdminType()
    {
        return new \ST\WebSiteBundle\Form\Pages\SponsorPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array(
            array(
                'name' => 'SponsorPage',
                'class'=> 'ST\WebSiteBundle\Entity\Pages\SponsorPage'
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