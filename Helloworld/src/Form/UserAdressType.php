<?php

namespace App\Form;

use App\Entity\UserAdresse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroRue', NumberType::class)
            ->add('rue', TextType::class)
            ->add('codePostal', NumberType::class)
            ->add('ville', TextType::class)
            ->add('save', SubmitType::class, [
                'label' => 'ajouter'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAdresse::class,
        ]);
    }
}
