<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Entity\Accomodation;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;

class BookingController extends AbstractController
{
    #[Route('/{id}/booking', name: 'app_booking')]
    public function index(Request $request, EntityManagerInterface $em, Accomodation $accomodation): Response
    {   $booking=new Booking();
         

        $form=$this->createForm(BookingType::class,$booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setAccomodation($accomodation);
            $user= $this->getUser();
            $booking->setUser($user);
            
           $em->persist($booking);
           $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('booking/index.html.twig', [
            'controller_name' => 'BookingController',
            'formBooking'=>$form,
            'accomodation'=>$accomodation
        ]);
    }

      //fonction qui permet d'afficher qlq element on choisir sur search
      #[Route('api/calender/{id}', name:"api_calendar")]
      public function searchAPi( Accomodation $accomodation): Response
      {
       $bookings=$accomodation->getBookings();
    
        $tab=[] ;
        foreach($bookings as $booking){
            $tab[]=[
                "title"=>"Réserver",
                "start " => $booking-> getstartDateAt()->format('Y-m-d'),
                "end" => $booking->getEndDateAt()->format('Y-m-d')
            ];
        }
        return $this->json($tab);
      }
}
