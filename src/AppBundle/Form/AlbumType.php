<?php

namespace AppBundle\Form;

use AppBundle\Entity\ArtistRepository;
use AppBundle\Entity\DistributorRepository;
use AppBundle\Entity\GenreRepository;
use AppBundle\Entity\MediumRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'album.form.title',
                'translation_domain' => 'AppBundle',
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'album.form.description',
                'translation_domain' => 'AppBundle',
            ])
            ->add('releaseDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control mb-2 release',
                ],
                'label' => 'album.form.release_date',
                'translation_domain' => 'AppBundle',
            ])
            ->add('recordYear', ChoiceType::class, [
                'choices' => range(1950, 2020),
                'choice_label' => function($choice, $key, $index) {
                    return $choice;
                },
                'attr' => [
                    'class' => 'form-control mb-2 js-datepicker',
                ],
                'label' => 'album.form.record_year',
                'translation_domain' => 'AppBundle',
            ])
            ->add('artist', EntityType::class, [
                'class' => 'AppBundle:Artist',
                'query_builder' => function (ArtistRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC')
                        ->addOrderBy('u.lastname', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'album.form.artist',
                'translation_domain' => 'AppBundle',
            ])
            ->add('distributor', EntityType::class, [
                'class' => 'AppBundle:Distributor',
                'query_builder' => function (DistributorRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'album.form.distributor',
                'translation_domain' => 'AppBundle',
            ])
            ->add('genres', EntityType::class, [
                'class' => 'AppBundle:Genre',
                'query_builder' => function (GenreRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.name_pl', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control mb-2 genres',
                    'multiple' => 'multiple',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'album.form.genres',
                'translation_domain' => 'AppBundle',
            ])
            ->add('mediums', EntityType::class, [
                'class' => 'AppBundle:Medium',
                'query_builder' => function (MediumRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control mb-2 mediums',
                    'multiple' => 'multiple',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'album.form.mediums',
                'translation_domain' => 'AppBundle',
            ])
            ->add('cover', FileType::class, [
                'attr' => [
                    'class' => 'btn btn-default mb-2',
                ],
                'label' => 'album.form.cover',
                'translation_domain' => 'AppBundle',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Album'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_album';
    }


}
