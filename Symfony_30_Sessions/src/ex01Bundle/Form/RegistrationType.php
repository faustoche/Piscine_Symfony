<?php

namespace App\ex01Bundle\Form;

use App\ex01Bundle\Entity\User;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType {

	public function buildForm($builder, $options) {

		$builder
			->add('username', TextType::class)
			->add('password', RepeatedType::class, [
				'type' => PasswordType::class,
				'invalid_message' => 'Passwords must match',
				'required' => true,
				'first_options' => ['label' => 'Password'],
				'second_options' => ['label' => 'Repeat Password'],
			]) // speicfique aux mdp, ca genre deux champs mdp et confirmation
			->add('save', SubmitType::class, ['label' => 'Register'])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void {
		// lien avec mon entité user
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}
}