<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('name')
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices'  => [
                    'Défaut' => 0,
                    'Live' => 1,
                    'Replay' => 2,
                ]
            ])
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'label' => "Événement"
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => "Catégory"
            ])
            ->add('position')
            ->add('platform', ChoiceType::class, [
                'label' => 'Plateforme',
                'choices'  => [
                    'Youtube' => 0,
                    'Twitch' => 1,
                    'Vimeo' => 2,
                    'Autre' => 10
                ]
            ])
            ->add('youtubeId')
            ->add('embedCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
