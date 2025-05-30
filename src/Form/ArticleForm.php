<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Block;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[])
            ->add('slug', TextType::class,[])
            ->add('image', FileType::class, ['mapped' => false, 'required' => false])
            ->add('keywords',TextType::class,[])
            ->add('description', TextareaType::class,[])
            ->add('content', TextareaType::class,[])
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
