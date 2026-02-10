<?php

namespace App\ex07Bundle\Form;

use App\ex07Bundle\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType {
	
	## pour la contruction du formulaire
	public function buildForm(FormBuilderInterface $builder, array $options): void {
		## le builder avec tous les attributs ici 

		$builder
			->add('username', TextType::class)
			->add('name', TextType::class)
			->add('email', TextType::class)
			->add('enable', CheckboxType::class, ['required' => false])
			->add('birthdate', DateType::class, [
				'widget' => 'single_text',
				'required' => false
			])
			->add('address', TextareaType::class)
			->add('save', SubmitType::class, ['label' => 'Save']);
	}


	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			'data_class' => Person::class,
		]);
	}
}