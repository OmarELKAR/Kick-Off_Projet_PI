<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextareaType::class,[
                'attr'=>['class'=>'form-control','rows'=>'1']
            ])
            ->add('email',TextareaType::class,[
                'attr'=>['class'=>'form-control','rows'=>'1']
            ])
            ->add('New_Password',PasswordType::class,[
                'mapped'=>false,
                'attr'=>['class'=>'form-control','rows'=>'1',]
            ])
            ->add('Confirm_New_Password',PasswordType::class,[
                'mapped'=>false,
                'attr'=>['class'=>'form-control','rows'=>'1',]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!
            ],
            'data_class' => User::class,

        ]);
    }
}
