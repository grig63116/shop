<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email()
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['trim' => true],
                'invalid_message' => 'The password fields must match.',
                'first_options' => [
                    'label' => 'Password',
                    'help' => 'Your password should be at least 8 characters, one capital letter and a symbol and should not contain any whitespace characters.',
                ],
                'second_options' => [
                    'label' => 'Repeat password',
                    'help' => 'Your password should match.'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z]).*$/',
                        'message' => 'Password should contain at least one capital letter.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*\W).*$/',
                        'message' => 'Password should contain at least one symbol.',
                    ]),
                    new Regex([
                        'pattern' => '/^((?!\s).)*$/',
                        'message' => 'Password should not contain any whitespace characters.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('street', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('zip', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('phone', TextType::class, [
                'required' => false,
            ])
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false,
                'constraints' => new IsTrue([
                    'message' => 'You should agree to our terms.'
                ])
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_token_id' => 'registration',
        ]);
    }
}