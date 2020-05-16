<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' =>[
                    'placeholder' => 'Surface minimale'
                ]

            ])

             ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' =>[
                    'placeholder' => 'Budjet max'
                ]
            ])
            //ajout du champ permettant de d'ajouter des options dans notre recherche
            ->add('options', EntityType::class, [
                'required' =>false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // dans cette partie nous pouvons traiter les informations que nous ne voulons totalement afficher.
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            // ajout de ma méthode
            'method' => 'GET',
            'csrf_protection' => false

        ]);
    }

    
    /**
     * getBlockPrefix permet de donner des paramètres un peu plus propre dans url après une recherche
     *
     * @return void 
     */
    public function getBlockPrefix()
    {
        return '';
    }
}