<?php

namespace App\ex13Bundle\Form;

use App\ex13Bundle\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', TextType::class)
            ->add('active', CheckboxType::class, ['required' => false])
            ->add('birthdate', DateType::class, ['widget' => 'single_text'])
            ->add('employedSince', DateType::class, ['widget' => 'single_text', 'label' => 'Hired On'])
            ->add('employedUntil', DateType::class, ['widget' => 'single_text', 'required' => false, 'label' => 'Contract End'])
            
            ->add('hours', ChoiceType::class, [
                'choices' => array_combine(Employee::HOURS, Employee::HOURS),
                'label' => 'Daily Hours'
            ])
            
            ->add('salary', IntegerType::class)
            
            ->add('position', ChoiceType::class, [
                'choices' => array_combine(Employee::POSITIONS, Employee::POSITIONS)
            ])
            
            // manager is an employee itself 
            ->add('manager', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => function (Employee $employee) {
                    return $employee->getFirstname() . ' ' . $employee->getLastname() . ' (' . $employee->getPosition() . ')';
                },
                'placeholder' => 'No Manager (CEO or Top Level)',
                'required' => false
            ])

            ->add('save', SubmitType::class, ['label' => 'Save Employee']);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults(['data_class' => Employee::class]);
    }
}