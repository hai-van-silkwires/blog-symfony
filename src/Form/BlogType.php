<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                  'required' => trưe,
              ])
            ->add('shortDescription', TextareaType::class, [
                  'required' => trưe,
              ])
            ->add('content', TextareaType::class, [
                  'required' => trưe,
              ])
            ->add('status', ChoiceType::class, [
                  'required' => trưe,
              ])
            ->add('categoryId', ChoiceType::class, [
                  'required' => trưe,
              ])
            ->add('featureImage', FileType::class, [
                  'required' => trưe,
              ])
        ;
    }
}