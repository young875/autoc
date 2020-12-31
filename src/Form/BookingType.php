<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'choices' => [
                    'Mr.' => 'Mr.',
                    'MMe' => 'MMe',
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Votre E-mail',
                'attr' => [
                    'placeholder' => 'Entrez votre e-mail'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length(null, 2, 200),
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse',
                'constraints' => new Length(null, 2, 250),
                'attr' => [
                    'placeholder' => 'Votre adresse'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Votre ville',
                'constraints' => new Length(null, 2, 200),
                'attr' => [
                    'placeholder' => 'Votre ville'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Votre pays',
                'constraints' => new Length(null, 2, 200),
                'attr' => [
                    'placeholder' => 'Votre pays'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => new Length(null, 2, 200),
                'attr' => [
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('demande', ChoiceType::class, [
                'choices' => Booking::DEMAMDE
            ])
            //->add('car')
            ->add('message', TextareaType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr'=>[
                    'rows' => 8,
                    'placeholder' => 'Bonjour,

Je souhaite réserver le véhicule suivant : '
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
