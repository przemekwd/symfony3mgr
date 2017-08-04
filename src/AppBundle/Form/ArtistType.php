<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'artist.form.name',
                'translation_domain' => 'AppBundle',
            ])
            ->add('firstname', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'artist.form.firstname',
                'translation_domain' => 'AppBundle',
            ])
            ->add('lastname', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'artist.form.lastname',
                'translation_domain' => 'AppBundle',
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control mb-2 js-datepicker',
                ],
                'label' => 'artist.form.birthdate_person_band',
                'translation_domain' => 'AppBundle',
            ])
            ->add('country', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'artist.form.country',
                'translation_domain' => 'AppBundle',
            ])
            ->add('band', null, [
                'attr' => [
                    'class' => 'ml-2',
                ],
                'label' => 'artist.form.band',
                'translation_domain' => 'AppBundle',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Artist'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_artist';
    }


}
