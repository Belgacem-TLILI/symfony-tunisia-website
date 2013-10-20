<?php

namespace ST\WebSiteBundle\Form\Pages;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * FormPageAdminType
 */
class FormPageAdminType extends \Kunstmaan\NodeBundle\Form\PageAdminType
{

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
                ->add('thanks', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'rich_editor'
                    )
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'st_websitebundle_formpagetype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\ST\WebSiteBundle\Entity\Pages\FormPage'
        ));
    }
}
