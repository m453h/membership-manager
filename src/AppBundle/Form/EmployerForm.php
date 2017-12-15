<?php

namespace AppBundle\Form;


use AppBundle\Entity\Employer;
use AppBundle\Entity\EmployerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, ['required' => true])
            ->add('employerType', EntityType::class, array(
                'class' => EmployerType::class,
                'choice_label' => 'description',
            ))
            ->add('name', null, ['required' => true])
            ->add('mobile', null, ['required' => true])
            ->add('fax', null, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employer::class
        ]);
    }

    public function getName()
    {
        return 'app_bundle_employer_form';
    }

}