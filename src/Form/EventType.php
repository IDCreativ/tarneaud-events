<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', CheckboxType::class, [
                'label'    => 'En cours',
                'required' => false,
            ])
            ->add('public')
            ->add('eventPassword', TextType::class, [
                'label' => 'Mot de passe (événement)',
                'required' => false
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Annoncé'                   => -1,
                    'Validé'                    => 0,
                    'Inscriptions ouvertes'     => 1,
                    'Terminé'                   => 2,
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'événement',
                'choices' => [
                    'Présentiel'    => 0,
                    'Distanciel'    => 1,
                    'Hybride'       => 2
                ]
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
