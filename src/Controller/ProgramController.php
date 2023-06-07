<?php
namespace App\Controller;
use App\Entity\Program;
use App\Entity\SeasonNumber;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Repository\SeasonNumberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/program', name: 'program_')]
Class ProgramController extends AbstractController
{  #[Route('/', name: 'index')]
public function index(ProgramRepository $programRepository): Response
{
    $programs = $programRepository->findAll();

    return $this->render(
        'program/index.html.twig',
        ['programs' => $programs]
    );
}
    #[Route('/new', name: 'new')]
public function new(Request $request, ProgramRepository $programRepository): Response
{
    $program = new Program();

    // Create the form, linked with $program
    $form = $this->createForm(ProgramType::class, $program);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $programRepository->save($program,true);

        $this->addFlash('success', 'The new program has been created');
        return $this->redirectToRoute('program_index');

    }
    // Render the form

    return $this->render('program/new.html.twig', [
        'form' => $form,
        'program' => $program,
    ]);
}
    #[Route('/{id}/', name: 'show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show( Program $program ,SeasonNumber $seasonNumber):Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,'seasonNumber' => $seasonNumber
        ]);

    }


    #[Route('/{program}/seasons/{seasonNumber}/', name: 'season_show',requirements: ["seasonNumber"=>"\d+"],methods: ['GET'])]
    public function showSeason(Program $program,SeasonNumber $seasonNumber ):Response
    {
        {
            return $this->render('program/season_show.html.twig', [
                'program' => $program,
                'seasonNumber' => $seasonNumber
            ]);
        }
}
}