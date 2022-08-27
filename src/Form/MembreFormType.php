<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MembreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('civilite', ChoiceType::class, array(
                'choices' => [
                    'Monsieur' => 'm',
                    'Madame' => 'f',
                ]
            ))
            ->add('roles', ChoiceType::class, array(
                'expanded' => true,
                'multiple' => true,
                'choices' => [
                    'Membre' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    // 'Membre & Admin' => ['ROLE_USER', 'ROLE_ADMIN']
                ],
                'required' => true
            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
