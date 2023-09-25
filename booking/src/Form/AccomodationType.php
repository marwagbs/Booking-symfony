<?php

namespace App\Form;

use App\Entity\Accomodation;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AccomodationType extends AbstractType
{   
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    
    public function onPreSetData(FormEvent $event): void
    {
        $accomodation = $event->getData();
        $form = $event->getForm();
        //modifier le formulaire de de l'héritage sans modifer l'adress et la city.
        if ($accomodation->getId()) {
            $form
                ->remove('address')
                ->remove('city');

        }
    }

    public function onPreSubmit(FormEvent $event): void
    { //fonctioon qui permet de remplir automatiquement la longitude zt latitiude à partir de l'entity spec_villes_france_free
        // un eventListener sur notre formulaire de création de logement => "PRE_SUBMIT"
        $accomodation = $event->getData();
        $form = $event->getForm();
        $city=$accomodation["city"];
        $conn = $this->em->getConnection();
        $sql = 'SELECT ville_nom_simple, ville_latitude_deg, ville_longitude_deg 
                FROM spec_villes_france_free
                WHERE ville_nom_simple = :city';
        $request = $conn->prepare($sql);
        $resultSet  = $request->executeQuery(['city' => $city]);
        $result = $resultSet->fetchAssociative();
        //si resultat est vide on affiche une erruer
        if(empty($result)){
            $form->addError(new FormError('La ville n\'existe pas'));
            return;
        }
            //Ajouter à l'objet ($accomodation) nos coordonnées :
        $form->getNormData()->setLatitude($result["ville_latitude_deg"]);
        $form->getNormData()->setLongitude($result["ville_longitude_deg"]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('address')
            ->add('city')
            ->add('price')
            ->add('area')
            ->add('email')
            //eventForm
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                [$this, 'onPreSubmit']
            )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Accomodation::class,
        ]);
    }
}
