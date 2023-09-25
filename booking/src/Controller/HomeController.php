<?php

namespace App\Controller;

use App\Entity\Accomodation;
use App\Repository\AccomodationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AccomodationRepository $accomodationRepo): Response
    {
        $accomodation=$accomodationRepo->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'accomodations'=>$accomodation
        ]);
    }


    #[Route('/search', name:"search")]
    public function search(Request $request, AccomodationRepository $accomodationRepo ): Response
    {
         $search= $request->query->get("city");
         $people= $request->query->get("people");
         $startDate= $request->query->get("startDate");
         $endDate= $request->query->get("endDate");
        $accomodations=$accomodationRepo->search($search,$people, $startDate,$endDate);
     
       
        
     return $this->renderForm('home/search.html.twig', [
        'accomodations' => $accomodations
    ]);

    }
}
