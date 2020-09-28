<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prenom", "Votre prenom"))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom"))
            ->add('birth', BirthdayType::class, [
                'label' => "Day of Birth",
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]
            ])
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre email"))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Votre mot de passe"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe", "veuillez confirmer votre mot de passe"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
