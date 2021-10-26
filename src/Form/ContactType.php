<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Naruto' => 'Il veut commander un naruto',
                    'Fairy Tail' => 'Il veut commander un fairy tail',
                    'Bleach' => 'Il veut commander un bleach',
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre message doit contenir au moins 10 caractères.',
                    ])
                ]
                // 'help' => 'test'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
