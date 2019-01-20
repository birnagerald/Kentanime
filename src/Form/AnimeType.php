<?php

namespace App\Form;

use App\Entity\Anime;
use App\Form\EpisodeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('anneeDeProduction')
            ->add('studio')
            ->add('classification', ChoiceType::class, [
                'choices' => array_flip(Anime::CLASSIFICATION),
            ]);
        $builder
            ->add('episodes', CollectionType::class, [
                'entry_type' => EpisodeType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,

            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Anime::class,
            'translation_domain' => 'forms',
        ]);
    }
}
