<?php

namespace ST\WebSiteBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;
use ST\WebSiteBundle\PagePartAdmin\FormPagePagePartAdminConfigurator;

/**
 * FormPage
 *
 * @ORM\Table(name="st_form_page")
 * @ORM\Entity
 */
class FormPage extends \Kunstmaan\NodeBundle\Entity\AbstractPage implements \Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface
{


    /**
     * Returns the default backend form type for this page
     *
     * @return \ST\WebSiteBundle\Form\Pages\FormPageAdminType
     */
    public function getDefaultAdminType()
    {
        return new \ST\WebSiteBundle\Form\Pages\FormPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array(
            array(
                'name' => 'FormPage',
                'class'=> 'ST\WebSiteBundle\Entity\Pages\FormPage'
            )
        );
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
       return array(
            new FormPagePagePartAdminConfigurator(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array("STWebSiteBundle:homepage");
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return "STWebSiteBundle:Pages:contact.html.twig";
    }
}