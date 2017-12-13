<?php

namespace AppBundle\Form\Accounts;

use AppBundle\Entity\UserAccounts\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword',PasswordType::class,['label'=>'Password'])
            ->add('plainPasswordConfirm',PasswordType::class,['label'=>'Confirm Password']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>User::class
        ]);
    }
   
   
}
