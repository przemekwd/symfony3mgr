<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number',null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'track.form.number',
                'translation_domain' => 'AppBundle',
            ])
            ->add('title',null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'track.form.name',
                'translation_domain' => 'AppBundle',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Track'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_track';
    }


}
