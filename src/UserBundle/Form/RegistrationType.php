<?php
/**
 * Overriding registration form of FOS
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('full_name', null, array('required' => true))
                ->add('roles', 'collection', array(
                'type'   => 'choice',
                'options'  => array(
                    'choices'  => array(
                        'ROLE_CUSTOM_USER'  => 'User',
                        'ROLE_ADMIN' => 'Admin',
                    ),
                    'label' => ":",
                    'required' => true
                ),
            ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
