<?php

namespace App\Form;

use App\Entity\House;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HouseType extends AccomodationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {parent::buildForm($builder, $options);
        $builder
          
            ->add('garage')
            ->add('pool')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => House::class,
        ]);
    }
}
