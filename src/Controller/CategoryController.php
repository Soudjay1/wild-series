<?php

namespace App\Controller;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('category_index');
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
        }
        // Render the form

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
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