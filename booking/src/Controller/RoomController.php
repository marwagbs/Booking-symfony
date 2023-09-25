<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Entity\Accomodation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
 {  // #[Security("app.user==accomodation.getUser()||is_granted('ROLE_ADMIN")]
    #[Route('{id}/room/create', name: 'room_create')]
    public function index( Accomodation $accomodation, Request $request, EntityManagerInterface $em): Response
    {   
        $room=new Room();
        $form=$this->createForm(RoomType::class,$room);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $room->setAccomodation($accomodation);
             $em->persist($room);
        //    foreach ($room->getRoomBeds() as $roombed)
        //     {
        //         $roombed->setRoom($room);
        //         $em->persist($roombed);
        //     }
           $em->flush();

            return $this->redirectToRoute('room_create',["id"=> $accomodation->getID()]);
        }
        return $this->renderForm('room/create.html.twig', [
            'controller_name' => 'RoomController',
            'roomForm'=> $form
        ]);
    }

    #[Route('/{id}/room/update', name: 'room_update')]
    public function update(Room $room, Accomodation $accomodation, Request $request, EntityManagerInterface $em): Response
    {

        $roomForm = $this->createForm(RoomType::class, $room);

        $roomForm->handleRequest($request);
        if($roomForm->isSubmitted() && $roomForm->isValid()){
            $em->persist($room);
            $em->flush();
            return $this->redirectToRoute('accomodation_list');
        }

        return $this->renderForm('room/create.html.twig', [
            'roomForm' => $roomForm,
        ]);
    }
}
