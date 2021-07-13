<?php

namespace App\Controller\Api\ApiCategory;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ApiGetCategoryController extends AbstractController
{

    /**
     * Serialiser et normalise toutes les catégories et les envoie dans au format Json
     * @param CategoryRepository $categoryRepository
     * @Route("/api/get/category", name="api_get_categories", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(CategoryRepository $categoryRepository)
    {
        //récupère toutes les catégories et retourne une réponse Json
        return  $this->json($categoryRepository->findAll(),200,[],['groups'=>'category']);
    }

}