<?php

namespace App\Controller\Api\ApiSubCategory;

use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ApiGetGetSubCategoryController extends AbstractController
{

    /**
     * Serialiser et normalise toutes les sous-catégories et les envoie dans au format Json
     * @param SubCategoryRepository $subCategoryRepository
     * @Route("/api/get/subcategory", name="api_get_subcategories", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(SubCategoryRepository $subCategoryRepository)
    {
        //récupère toutes les sous-catégories et retourne une réponse Json
        return  $this->json($subCategoryRepository->findAll(),200,[],['groups'=>'subcategory']);
    }

}