<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Contest;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('questionStatus', ChoiceType::class, [
                'label' => 'Statut des questions',
                'choices' => [
                    'Invisible'   => 0,
                    'Visible'     => 1,
                    'Terminée'    => 2
                ]
            ])
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'choice_label' => 'name',
                'label' => 'Événement'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contest::class,
        ]);
    }
}
