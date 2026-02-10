<?php

namespace App\ex12Bundle\Form;

use App\ex12Bundle\Entity\BankAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BankAccountType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('bankName', TextType::class, ['label' => 'Bank Name'])
            ->add('iban', TextType::class, ['label' => 'IBAN']);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults(['data_class' => BankAccount::class]);
    }
}