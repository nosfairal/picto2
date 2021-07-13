<?php

namespace App\Controller\Api\ApiPictogram;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PictogramRepository;


class ApiGetPictogramController extends AbstractController
{
    /**
     * Serialiser et normalise tous les pictogrammes et les envoie au format Json 
     * contenant tous les pictogrammes et leur catégorie associées
     * @param PictogramRepository $pictogramRepository
     * @Route("/api/get/pictogram", name="api_get_index", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(PictogramRepository $pictogramRepository)
    {
         return  $this->json($pictogramRepository->findAll(),200,[],['groups'=>'pictogram']);
    }

}