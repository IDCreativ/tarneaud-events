<?php

namespace App\Form;

use App\Entity\GeneralConfiguration;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class GeneralConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('tagline')
            ->add('event')
            ->add('logoFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'delete',
                'download_uri' => '...',
                'download_label' => true,
                'asset_helper' => true,
                'imagine_pattern' => 'form_minia',
            ])
            ->add('copyright', CKEditorType::class)
            ->add('googleAnalytics')
            ->add('facebook')
            ->add('twitter')
            ->add('instagram')
            ->add('linkedin')
            ->add('youtube')
            ->add('website')
            ->add('modules')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GeneralConfiguration::class,
        ]);
    }
}
