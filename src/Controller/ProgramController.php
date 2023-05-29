<?php
// src/Controller/ProgramController.php
namespace App\Controller;
use App\Repository\ProgramRepository;
use App\Repository\SeasonNumberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/program', name: 'program_')]
Class ProgramController extends AbstractController
{
    #[Route('/{id}/', name: 'show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(int $id, ProgramRepository $programRepository ,SeasonNumberRepository $seasonNumberRepository):Response
    {
        $program = $programRepository->find(['id' => $id]);
        $seasonNumbers = $seasonNumberRepository->findAll();

        return $this->render('program/show.html.twig', [
            'program' => $program,'seasonNumbers' => $seasonNumbers
        ]);

    }

    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }
    #[Route('/{programId}/seasons/{seasonId}/', name: 'season_show',methods: ['GET'])]
    public function showSeason(int $programId, int $seasonId , ProgramRepository $programRepository,SeasonNumberRepository $seasonNumberRepository ):Response
    {
        {
            $programId = $programRepository->find($programId);
            $seasonNumberId = $seasonNumberRepository->find($seasonId);

            return $this->render('program/season_show.html.twig', [
                'program' => $programId,
                'seasonNumber' => $seasonNumberId
            ]);
        }

}
}