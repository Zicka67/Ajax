<?php

namespace App\Form;

use App\Entity\Video;
use App\Entity\Visibility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre (obligatoire)"
            ])
            ->add('description', TextareaType::class)
            ->add('thumbnail', FileType::class, [
                'label' => "Mignature"
            ])
            ->add('videoFile', FileType::class, [
                'label' => "Vidéo"
            ])
            ->add('visibility', EntityType::class, [
                'class' => Visibility::class,
                'label' => 'Visibilité',
                'choice_label' => 'label',
                'expanded' => true,
                'multiple' => false
            ])
            ->add('save', SubmitType::class , [ 
                'attr' => [ 
                    'class' => 'btn btn-primary'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
