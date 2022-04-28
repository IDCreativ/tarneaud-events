<?php

namespace App\Form;

use App\Entity\Poll;
use App\Entity\PollOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PollOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poll', EntityType::class, [
                'class' => Poll::class,
                'label' => 'Sondage',
                'required' => true
            ])
            ->add('description', TextType::class, [
                'label' => 'Réponse',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PollOption::class,
        ]);
    }
}
