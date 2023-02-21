<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TeamType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextareaType::class, [
                'attr' => ['class' => 'form-control ', 'rows'=>'1'],])
            ->add('players' ,  EntityType::class, [
             'class'=>User::class,
             'choice_label'=>'username',
             'multiple'=>True,

                'attr' => [
        'class' => 'form-select',
                    'multiple'=>True,
                    'aria-label'=>"multiple select example"
    ],
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
