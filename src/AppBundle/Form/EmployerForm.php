<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, ['required' => true])
            ->add('employer_type_id', EntityType::class, array(
                'class' => Employer::class,
                'choice_label' => 'employer_type',
            ))
            ->add('name', null, ['required' => true])
            ->add('mobile', null, ['required' => true])
            ->add('fax', null, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmployerType::class
        ]);
    }

    public function getName()
    {
        return 'app_bundle_employer_form';
    }

}