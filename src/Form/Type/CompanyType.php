<?php

// src/Form/CompanyType.php

namespace App\Form\Type;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Company Name',
                'required' => true,
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'required' => true,
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => true,
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Postal Code',
                'required' => true,
            ])
            ->add('sector', TextType::class, [
                'label' => 'Sector',
                'required' => false,
            ])
            ->add('size', NumberType::class, [
                'label' => 'Size',
                'required' => false,
            ])
            ->add('website', UrlType::class, [
                'label' => 'Website',
                'required' => false,
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Phone Number',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('type', TextType::class, [
                'label' => 'Type',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Company',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
