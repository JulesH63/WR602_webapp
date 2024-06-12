<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}