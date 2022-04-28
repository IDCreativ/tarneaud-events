<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Chapter;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du programme'
            ])
            ->add('position')
            ->add('type', ChoiceType::class, [
                'label' => 'Type de bloc',
                'choices' => [
                    'Défaut (Texte + image)'    => 0,
                    'Texte + image'   => 0,
                    'Image seule'   => 1,
                ]
            ])
            ->add('blockWidth', ChoiceType::class, [
                'label' => 'Taille du bloc',
                'choices' => [
                    'Défaut (1/3)'    => 4,
                    '1/3'   => 4,
                    '1/4'   => 3,
                    '1/2'   => 6,
                    '1/1'   => 12,
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'delete',
                'download_uri' => '...',
                'download_label' => true,
                'asset_helper' => true,
                'imagine_pattern' => 'form_minia',
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
            ->add('chapter', EntityType::class, [
                'class' => Chapter::class,
                'required' => false,
                'label' => "Chapitre"
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
            'data_class' => Programme::class,
        ]);
    }
}
