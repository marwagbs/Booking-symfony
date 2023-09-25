<?php

namespace App\Controller;

use App\Entity\Bed;
use App\Form\BedType;
use App\Repository\BedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bed')]
class BedController extends AbstractController
{
    #[Route('/', name: 'app_bed_index', methods: ['GET'])]
    public function index(BedRepository $bedRepository): Response
    {
        return $this->render('bed/index.html.twig', [
            'beds' => $bedRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bed_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BedRepository $bedRepository): Response
    {
        $bed = new Bed();
        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bedRepository->save($bed, true);

            return $this->redirectToRoute('app_bed_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bed/new.html.twig', [
            'bed' => $bed,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bed_show', methods: ['GET'])]
    public function show(Bed $bed): Response
    {
        return $this->render('bed/show.html.twig', [
            'bed' => $bed,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bed_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bed $bed, BedRepository $bedRepository): Response
    {
        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bedRepository->save($bed, true);

            return $this->redirectToRoute('app_bed_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bed/edit.html.twig', [
            'bed' => $bed,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bed_delete', methods: ['POST'])]
    public function delete(Request $request, Bed $bed, BedRepository $bedRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bed->getId(), $request->request->get('_token'))) {
            $bedRepository->remove($bed, true);
        }

        return $this->redirectToRoute('app_bed_index', [], Response::HTTP_SEE_OTHER);
    }
}
