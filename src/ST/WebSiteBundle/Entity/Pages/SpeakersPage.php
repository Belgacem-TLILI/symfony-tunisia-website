<?php

namespace ST\WebSiteBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpeakersPage
 *
 * @ORM\Table(name="st_speakers_page")
 * @ORM\Entity
 */
class SpeakersPage extends \Kunstmaan\NodeBundle\Entity\AbstractPage implements \Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface
{


    /**
     * Returns the default backend form type for this page
     *
     * @return \ST\WebSiteBundle\Form\Pages\SpeakersPageAdminType
     */
    public function getDefaultAdminType()
    {
        return new \ST\WebSiteBundle\Form\Pages\SpeakersPageAdminType();
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
            ),
            array(
                'name' => 'SpeakersPage',
                'class'=> 'ST\WebSiteBundle\Entity\Pages\SpeakersPage'
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