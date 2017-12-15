<?php

namespace AppBundle\Form;

use AppBundle\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberFormType extends  AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',null,['required'=>true])
            ->add('surname',null,['required'=>true])
            ->add('secondName',null,['required'=>true])

            ->add('sex', ChoiceType::class, array(
                'choices'  => array(
                    'Select sex'=> null,
                    'Male' => 'Male',
                    'Female' => 'Female',
                )))

            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'date'],
                'html5' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' =>Member::class
        ]);
    }


}