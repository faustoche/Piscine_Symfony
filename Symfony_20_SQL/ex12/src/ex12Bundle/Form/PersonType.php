<?php

namespace App\ex12Bundle\Form;

use App\ex12Bundle\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options): void {
		$builder
			->add('username', TextType::class)
			->add('name', TextType::class)
			->add('email', TextType::class)
			->add('phone', TextType::class, ['required' => false, 'label' => 'Phone Number'])
			->add('enable', CheckboxType::class, ['required' => false])
			->add('birthdate', DateType::class, [
				'widget' => 'single_text',
				'required' => false
			])

			// gestion des relations
			->add('address', AddressType::class, ['label' => 'Address'])
			->add('bankAccount', BankAccountType::class, ['label' => 'Bank Info'])
			->add('save', SubmitType::class, ['label' => 'Add']);
	}

	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			'data_class' => Person::class,
		]);
	}
}