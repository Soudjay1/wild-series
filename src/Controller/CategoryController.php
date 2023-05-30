<?php

namespace App\Controller;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
#[Route('/', name: 'index')]
public function index(CategoryRepository $categoryRepository):Response
{
    $category = $categoryRepository->findAll();
    return $this->render(
        'category/index.html.twig',
        ['category' => $category]);
}
    #[Route('/{id}', name: 'show')]
    public function show(int $id, CategoryRepository $categoryRepository, ProgramRepository $programRepository):Response
    {
        $categories = $categoryRepository->findBy(['id' => $id],['id' => 'DESC'],3);
        $programs = $programRepository->findAll();

        return $this->render('category/show.html.twig', [
            'categories' => $categories,
            'programs' => $programs]);
    }
}