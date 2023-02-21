<?php

namespace App\Form;

use App\Entity\Matche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MatcheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('Date', DateType::class, array('widget' => 'single_text'))
            ->add('time', DateType::class, array('widget' => 'single_text'))
            ->add('etat', ChoiceType::class, ['choices' => [
                'Ouvert' => 'Ouvert',
                'Privée' => 'Privée',
            ]])
            ->add('Jmax')
            ->add('time')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate',
            ],
            'data_class' => Matche::class,
        ]);
    }
}
