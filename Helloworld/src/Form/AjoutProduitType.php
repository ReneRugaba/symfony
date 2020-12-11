<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('prix', MoneyType::class)
            ->add('color', ColorType::class)
            ->add('isShipped', CheckboxType::class)
            ->add('vendeur')
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'libelle'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter produit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
