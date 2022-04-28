<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Periode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PeriodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la période'
            ])
            ->add('dateStart', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'required' => false
            ])
            ->add('dateEnd', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => false
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
            'data_class' => Periode::class,
        ]);
    }
}
