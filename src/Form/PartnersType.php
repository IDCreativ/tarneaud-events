<?php

namespace App\Form;

use App\Entity\Partners;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('featured')
            ->add('name', TextType::class, [
                'label'    => 'Nom',
            ])
            ->add('height', IntegerType::class, [
                'label'    => 'Hauteur',
                'required' => false
            ])
            ->add('logoFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer',
                'download_uri' => '...',
                'download_label' => false,
                'asset_helper' => true,
                'label'    => 'Logo (Fichier image)',
                // 'imagine_pattern' => 'form_minia',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}
