<?php

namespace App\Controller;

use App\Entity\SeasonNumber;
use App\Form\SeasonNumberType;
use App\Repository\SeasonNumberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/season/number')]
class SeasonNumberController extends AbstractController
{
    #[Route('/', name: 'app_season_number_index', methods: ['GET'])]
    public function index(SeasonNumberRepository $seasonNumberRepository): Response
    {
        return $this->render('season_number/index.html.twig', [
            'season_numbers' => $seasonNumberRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'season_number_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SeasonNumberRepository $seasonNumberRepository): Response
    {
        $seasonNumber = new SeasonNumber();
        $form = $this->createForm(SeasonNumberType::class, $seasonNumber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonNumberRepository->save($seasonNumber, true);

            return $this->redirectToRoute('season_number_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('season_number/new.html.twig', [
            'season_number' => $seasonNumber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_season_number_show', methods: ['GET'])]
    public function show(SeasonNumber $seasonNumber): Response
    {
        return $this->render('season_number/show.html.twig', [
            'season_number' => $seasonNumber,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_season_number_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SeasonNumber $seasonNumber, SeasonNumberRepository $seasonNumberRepository): Response
    {
        $form = $this->createForm(SeasonNumberType::class, $seasonNumber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonNumberRepository->save($seasonNumber, true);

            return $this->redirectToRoute('season_number_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('season_number/edit.html.twig', [
            'season_number' => $seasonNumber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_season_number_delete', methods: ['POST'])]
    public function delete(Request $request, SeasonNumber $seasonNumber, SeasonNumberRepository $seasonNumberRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seasonNumber->getId(), $request->request->get('_token'))) {
            $seasonNumberRepository->remove($seasonNumber, true);

            $this->addFlash('danger', 'The new season has been deleted');

        }
        return $this->redirectToRoute('season_number_new');

    }
}
