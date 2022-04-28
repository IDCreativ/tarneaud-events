<?php

namespace App\Form;

use App\Entity\ContestQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContestQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question')
            ->add('contest')
            ->add('status', ChoiceType::class, [
                'label' => 'Statut de la question',
                'choices' => [
                    'Invisible'   => 0,
                    'Visible'     => 1,
                    'Terminée'    => 2
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContestQuestion::class,
        ]);
    }
}
