<?php

namespace AppBundle\Form;

use AppBundle\Entity\Beneficiary;
use AppBundle\Entity\RelationshipType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BeneficiaryFormType extends  AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',null,['required'=>true])
            ->add('surname',null,['required'=>true])
            ->add('secondName',null,['required'=>true])
            ->add('sex',null,['required'=>true])
            ->add('relationshipTypeId', EntityType::class, array(
                // query choices from this entity
                'class' => RelationshipType::class,

                // use the User.username property as the visible option string
                'choice_label' => 'description'))
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'date'],
                'html5' => false,
             ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' =>Beneficiary::class
        ]);
    }


}