<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'choices' => Contact::TITRE
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Votre E-mail'
                ]
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre pays'
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre ville'
                ]
            ])
            ->add('zip', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Votre Code postal'
                ]
            ])
            ->add('object', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre péoccupation'
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => '100',
                    'placeholder' => "MESSAGE
                    
Pour une réponse encore plus précise, vous pouvez nous laisser un maximum d’informations ... (référence véhicule, lien vers page du site par exemple)"

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}
