<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email' , EmailType::class, [
                'label' => 'Votre Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>"Un email vous sera envoyé à cette adresse"
                ]
            ])
            //->add('password' , PasswordType::class, [
              //  'label' => 'Mot de passe',
              //  'attr' => [
               //     'class' => 'form-control'
              // ]
          //  ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les mots de passe doivent être identiques !',
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'new-password'

                ],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation Mot de passe'],
            ])
            ->add('avatar' , TextType::class, [
                'label' => 'Votre avatar',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('userName' , TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
