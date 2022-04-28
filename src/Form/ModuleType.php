<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\GeneralConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('active')
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            // ->add('slug', TextType::class, [
            //     'label' => 'Slug'
            // ])
            ->add('generalConfiguration', EntityType::class, [
                'label' => 'Configuration',
                'class' => GeneralConfiguration::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
