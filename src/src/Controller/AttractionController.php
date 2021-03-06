<?php

namespace App\Controller;

use App\Entity\Attraction;
use App\Form\AttractionType;
use App\Repository\AttractionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/attraction')]
class AttractionController extends AbstractController
{
    #[Route('/', name: 'app_attraction_index', methods: ['GET'])]
    public function index(AttractionRepository $attractionRepository): Response
    {
        return $this->render('attraction/index.html.twig', [
            'attractions' => $attractionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_attraction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AttractionRepository $attractionRepository): Response
    {
        $attraction = new Attraction();
        $form = $this->createForm(AttractionType::class, $attraction);
        $form->remove("createdAt");
        $form->remove("updatedAt");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attraction->setCreatedAt(new \DateTimeImmutable());
            $attraction->setUpdatedAt(new \DateTimeImmutable());
            $attractionRepository->add($attraction, true);

            return $this->redirectToRoute('app_attraction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attraction/new.html.twig', [
            'attraction' => $attraction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attraction_show', methods: ['GET'])]
    public function show(Attraction $attraction): Response
    {
        return $this->render('attraction/show.html.twig', [
            'attraction' => $attraction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_attraction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Attraction $attraction, AttractionRepository $attractionRepository): Response
    {
        $form = $this->createForm(AttractionType::class, $attraction);
        $form->remove("createdAt");
        $form->remove("updatedAt");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attraction->setUpdatedAt(new \DateTimeImmutable());
            $attractionRepository->add($attraction, true);

            return $this->redirectToRoute('app_attraction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attraction/edit.html.twig', [
            'attraction' => $attraction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attraction_delete', methods: ['POST'])]
    public function delete(Request $request, Attraction $attraction, AttractionRepository $attractionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attraction->getId(), $request->request->get('_token'))) {
            $attractionRepository->remove($attraction, true);
        }

        return $this->redirectToRoute('app_attraction_index', [], Response::HTTP_SEE_OTHER);
    }
}
