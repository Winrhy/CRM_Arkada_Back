<?php

namespace App\Form\Type;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Uid\Uuid;

class ContactType extends AbstractType
{
    /**
     * Build the contact form.
     *
     * @param FormBuilderInterface $builder The form builder.
     * @param array $options The options for building the form.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, [
                'required' => false,
            ])
            ->add('firstName', TextType::class, ['required' => true])
            ->add('lastName', TextType::class, ['required' => true])
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('email', EmailType::class, ['required' => true])
            ->add('address', TextType::class, ['required' => false])
            ->add('country', TextType::class, ['required' => false])
            ->add('city', TextType::class, ['required' => false])
            ->add('postalCode', TextType::class, ['required' => false])
            ->add('marketing', CheckboxType::class, ['required' => false])
            ->add('type', TextType::class, ['required' => false])
            ->add('status', TextType::class, ['required' => false])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('modifiedAt', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('lastInteraction', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('interactionCount', IntegerType::class, ['required' => false])
            ->add('comment', TextType::class, ['required' => false])
            ->add('source', TextType::class, ['required' => false])
            ->add('language', TextType::class, ['required' => true])
            ->add('userId', TextType::class, ['required' => false])
        ;
    }

    /**
     * Configure the options for the contact form.
     *
     * @param OptionsResolver $resolver The options resolver.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
            'csrf_protection' => false,
        ]);
    }
}
