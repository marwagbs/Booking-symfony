<?php

namespace App\Form;

use App\Entity\Apartement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApartementType extends AccomodationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {parent::buildForm($builder, $options);
        $builder
           
            ->add('floor')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apartement::class,
        ]);
    }
}
