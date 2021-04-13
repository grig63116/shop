<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints;
use App\Entity\User;

/**
 * Class RegistrationFormType
 * @package App\Form
 */
class RegistrationFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', Type\EmailType::class, [
                'constraints' => [
                    new Constraints\Email()
                ]
            ])
            ->add('plainPassword', Type\RepeatedType::class, [
                'type' => Type\PasswordType::class,
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
                    new Constraints\NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Constraints\Regex([
                        'pattern' => '/^(?=.*[A-Z]).*$/',
                        'message' => 'Password should contain at least one capital letter.',
                    ]),
                    new Constraints\Regex([
                        'pattern' => '/^(?=.*\W).*$/',
                        'message' => 'Password should contain at least one symbol.',
                    ]),
                    new Constraints\Regex([
                        'pattern' => '/^((?!\s).)*$/',
                        'message' => 'Password should not contain any whitespace characters.',
                    ]),
                    new Constraints\Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('firstName', Type\TextType::class, [
                'constraints' => [
                    new Constraints\NotBlank()
                ]
            ])
            ->add('lastName', Type\TextType::class, [
                'constraints' => [
                    new Constraints\NotBlank()
                ]
            ])
            ->add('street', Type\TextType::class, [
                'constraints' => [
                    new Constraints\NotBlank()
                ]
            ])
            ->add('zip', Type\TextType::class, [
                'constraints' => [
                    new Constraints\NotBlank()
                ]
            ])
            ->add('city', Type\TextType::class, [
                'constraints' => [
                    new Constraints\NotBlank()
                ]
            ])
            ->add('phone', Type\TextType::class, [
                'required' => false,
            ])
            ->add('termsAccepted', Type\CheckboxType::class, [
                'mapped' => false,
                'constraints' => new Constraints\IsTrue([
                    'message' => 'You should agree to our terms.'
                ])
            ])
            ->add('submit', Type\SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_token_id' => 'registration',
        ]);
    }
}