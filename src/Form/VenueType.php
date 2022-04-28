<?php

namespace App\Form;

use App\Entity\Venue;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VenueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', CKEditorType::class)
            ->add('adress', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venue::class,
        ]);
    }
}
