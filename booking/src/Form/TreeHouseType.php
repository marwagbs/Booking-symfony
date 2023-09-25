<?php

namespace App\Form;

use App\Entity\TreeHouse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreeHouseType extends AccomodationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   parent::buildForm($builder, $options);
        $builder
          
            ->add('treeHeight')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TreeHouse::class,
        ]);
    }
}
