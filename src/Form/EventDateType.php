<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventDate;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', CKEditorType::class)
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
            ->add('venue')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventDate::class,
        ]);
    }
}
