<?php
// src/Form/PaymentType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('paymentMethod', ChoiceType::class, [
                'choices'  => [
                    'MasterCard' => 'mastercard',
                    'Paypal' => 'paypal',
                    'Visa' => 'visa',
                ],
                'expanded' => true, // renders as radio buttons
                'multiple' => false,
                'label' => 'Moyen de paiement'
            ])
            ->add('cardNumber', TextType::class)
            ->add('cvv', TextType::class)
            ->add('expirationDate', TextType::class)
            ->add('address', TextType::class)
            ->add('postalCode', TextType::class)
            ->add('city',TextType::class)
            ->add('country',TextType::class)
            ->add('phoneNumber',TextType::class);
    }

}
