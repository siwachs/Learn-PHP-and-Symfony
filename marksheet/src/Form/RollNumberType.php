<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RollNumberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rollNumber', type: IntegerType::class, options: ['label' => 'Roll Number', 'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 1, 'max' => 10]),
            ]])->add('fetchResult', type: SubmitType::class, options: ['label' => 'Fetch Result']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
