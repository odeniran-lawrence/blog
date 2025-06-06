<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Block;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,['attr' => ['placeholder' => "Titre de l'article"]])
            ->add('slug', TextType::class,[])
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name', 'required' => false])
            ->add('image',  DropzoneType::class, [
                'attr' => ['placeholder' => 'Selectionnez une image',
                'class' => 'mb-4'
                ], 'mapped' => false, 'required' => false])





            ->add('keywords',TextType::class,['attr' => ['placeholder' => 'Choisissez des mots-clés']
                ])
            ->add('description', TextareaType::class,['attr' => ['placeholder' => "Résumé de l'article"]
                ])
            ->add('content', TextareaType::class,['attr' => ['placeholder' => 'Rédigez votre article ici']
                ])
            ->add('submit', SubmitType::class,[
                'label' => 'Enregister'
            ])
            // ->add('is_published')
            // ->add('is_archived')
            // ->add('created_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updated_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('blocks', EntityType::class, [
            //     'class' => Block::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            // ->add('author', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
