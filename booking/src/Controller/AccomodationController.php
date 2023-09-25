<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Entity\House;
use App\Form\BoatType;
use App\Form\HouseType;
use App\Entity\Accomodation;
use App\Form\AccomodationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccomodationController extends AbstractController
{
    #[Route('/accomodation', name: 'accomodation')]
    public function index(): Response
    {
        return $this->render('accomodation/index.html.twig', [
            'controller_name' => 'AccomodationController',
        ]);
    }
    #[IsGranted("ROLE_USER")]
    #[Route('/accomodation/create', name: 'accomodation_create')]
    public function create(Request $request, EntityManagerInterface $em ): Response
    {   $type=$request->get('type');
        //$place=new Boat();
       $place=new ("App\\Entity\\".$type)();
       
        // if (class_exists('App\\Entity\\' . $type) && get_parent_class('App\\Entity\\' . $type) == "App\\Entity\\Place") {
        //     $place = new ('App\\Entity\\' . $type)();
        //     $form=$this->createForm('App\\Form\\'.$type. 'Type'::class,$place);
        // }else{
        //     $place = new House();
        //     $form = $this->createForm(HouseType::class, $place);
        // }
    
        $user= $this->getUser();
        $place->setUser($user);
         $form=$this->createForm('App\\Form\\'.$type. 'Type'::class,$place);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $em->persist($place);
           $em->flush();

            return $this->redirectToRoute('accomodation_list');
        }
        return $this->renderForm('accomodation/create.html.twig', [
            'accomodationForm' => $form,
        ]);
    }
    #[IsGranted("ROLE_USER")]
    #[Route('/accomodation/list', name: 'accomodation_list')]
    public function list(): Response
    {    $accomodations=$this->getUser()->getAccomodations();
        return $this->render('accomodation/list.html.twig', [
            "accomodations"=>$accomodations
        ]);
    }



    #[IsGranted("ROLE_USER")]
    #[Route('/accomodation/edit/{id}', name: 'accomodation_edit')]
    public function editer(Accomodation $accomodation, Request $request, EntityManagerInterface $em): Response
    {  
        $typeForm = str_replace("Entity","Form",get_class($accomodation))."Type";
       

        $form=$this->createForm($typeForm, $accomodation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $em->flush();

            return $this->redirectToRoute('accomodation_list');
        }
        return $this->renderForm('accomodation/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/accomodation/remove/{id}', name: 'accomodation_remove')]
    public function remove(Accomodation $accomodation, Request $request, EntityManagerInterface $em): Response
    {

        $em->remove($accomodation);
        $em->flush();

        return $this->redirectToRoute('accomodation_list');

    }
}
