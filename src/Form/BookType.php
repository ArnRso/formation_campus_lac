<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'attr' => [
                    'placeholder' => 'Merci de renseigner le titre du livre'
                ]
            ])
            ->add('author', TextType::class)
            ->add('isbn', NumberType::class, [
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 13,
                        'minMessage' => 'Le ISBN est trop court',
                        'maxMessage' => 'Le ISBN est trop long'
                    ])
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }
}