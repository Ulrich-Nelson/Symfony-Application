<?php

namespace Tapinfort\RecaptchaBundle\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Tapinfort\RecaptchaBundle\Constraints\Recaptcha;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;



// création du bouton de notre recaptcha
class RecaptchaSubmitType extends AbstractType
{    
    /**
     * key
     *
     * @var string
     */
    private $key;
    
    public function __construct(string $key)
    {
        $this->key = $key;
    }

     public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
            'constraints' => new Recaptcha()
        ]);
    }

    // fonction permettant d'ajouter un label à notre bouton de racaptcha
    public function buildView(FormView $view, FormInterface $form,  array $options)
    {
        $view->vars['label'] = false;
        $view->vars['key'] = $this->key;
        $view->vars['button'] = $options['label'];
    }

    public function getBlockPrefix()
    {
        return 'recaptcha_submit';
    }

    public function getParent()
    {
        return TextType::class;
    }

    

}