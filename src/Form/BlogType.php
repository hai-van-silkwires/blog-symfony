<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class BlogType extends AbstractType
{
    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'choices' => [
    //             'Standard Shipping' => 'standard',
    //             'Expedited Shipping' => 'expedited',
    //             'Priority Shipping' => 'priority',
    //         ],
    //     ]);
    // }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // if (in_array('ROLE_ADMIN', $options['role']) || in_array('ROLE_EDITOR', $options['role'])) {
        //     $builder->add('action-update', 'text');
        //     $builder->add('action-delete', 'text');
        // }
    }
}