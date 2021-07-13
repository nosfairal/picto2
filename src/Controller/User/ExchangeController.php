<?php

namespace App\Controller\User;

use App\Entity\Patient;
use App\Repository\CategoryRepository;
use App\Repository\PictogramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/user/echange/{id}", name="exchange")
     */
    public function index($id, CategoryRepository $repository, PictogramRepository $pictogramRepository): Response
    {
        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($id);
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }
        $categories = $repository->findAll();
        $pictos = $pictogramRepository->findAll();
        return $this->render('exchange/index.html.twig', [
            'patient' => $patient,
            'categories' => $categories,
            'pictos' => $pictos
        ]);
    }
}