<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationMailController extends AbstractController
{
    #[Route('/confirmation/mail', name: 'app_confirmation_mail')]
    public function index(): Response
    {
        return $this->render('confirmation_mail/index.html.twig', [
            'controller_name' => 'ConfirmationMailController',
        ]);
    }
}
