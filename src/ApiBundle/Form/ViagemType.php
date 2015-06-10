<?php

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ViagemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('de')
            ->add('para')
            ->add('dataIda','datetime',array(
                'widget' => 'single_text',
                'attr' => array('class' => 'input-medium dtp'),
                'required'  => true,
            ))
            ->add('dataVolta','datetime',array(
                'widget' => 'single_text',
                'attr' => array('class' => 'input-medium dtp'),
                'required'  => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ApiBundle\Entity\Viagem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'apibundle_viagem';
    }
}
