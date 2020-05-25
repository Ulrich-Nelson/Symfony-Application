<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tapinfort\RecaptchaBundle\Type\RecaptchaSubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('phone', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('captcha', RecaptchaSubmitType::class, [
                'label' => 'Envoyer',
                'attr' =>[
                    'class' => 'btn btn-primary']
            ])

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // dans cette partie nous pouvons traiter les informations que nous ne voulons totalement afficher.
        $resolver->setDefaults([
            'data_class' => Contact::class

        ]);
    }

}
