<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les mots de passe doivent être identiques !',
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'new-password',
                    
                    

                    

                ],
                'constraints' =>[
                    new NotBlank(),
                    new Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)^[a-zA-Z\d]{8,}$/',"Votre mot de passe doit contenir une Majuscule, une minuscule et 8 caratères minimum !"),
                    new Length([
                        'min'=> 8,
                        'minMessage'=>"Votre mot de passe doit comporter au moins  8 caratères",
                        'max'=> 255,
                        
                        ])
                    ],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation Mot de passe'],
                
            ])
            ->add('submit',SubmitType::class, [
                'label'=> 'Valider'
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
