<?php

namespace AppBundle\Form;

use AppBundle\Entity\Contribution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContributionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employeeContribution', null, ['required' => true])
            ->add('employerContribution', null, ['required' => true])
            ->add('totalContribution', null, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contribution::class
        ]);
    }

    public function getName()
    {
        return 'app_bundle_contribution_form';
    }
}