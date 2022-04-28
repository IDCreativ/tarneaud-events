<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Chapter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ChapterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description')
            ->add('showTime', ChoiceType::class, [
                'label'     => 'Montrer l\'horaire',
                'choices'   => [
                    'Oui'   => 1,
                    'Non'   => 0
                ]
            ])
            ->add('dateStart', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début'
            ])
            ->add('dateEnd', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin'
            ])
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'label' => "Événement"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chapter::class,
        ]);
    }
}
