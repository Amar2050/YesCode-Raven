<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , TextType::class , [
                "label" => "Titre de l'article",
                "attr"  => ["placeholder" => "Votre titre ici..."]
            ])
            ->add('intro', TextType::class , [
                "label" => "Introduction de votre article",
                "attr"  => ["placeholder" => "Une intro accrocheuse..."]
            ] )
            ->add('content', TextareaType::class , [
                "label" => "Contenu de votre article",
                "attr"  => ["placeholder" => "Ici un roman...lachez-vous..."]
            ])
            ->add('image', TextType::class, [
                "label" => "URL (adresse de l'image)",
                "attr"  => ["placeholder" => "https://...."]
            ])
            ->add('category', EntityType::class, [
                "label" => "Catégorie",
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
