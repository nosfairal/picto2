<?php

namespace App\Controller\User;

use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
/**
 * @Route("admin/user")
 */
    {
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/{id}", name="user_menu")
     */
    public function index($id): Response
    {
        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($id);
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }
        return $this->render('user/index.html.twig', [
            'patient' => $patient
        ]);
    }
//
//    /**
//     * @Route("/echange/{id}", name="exchange")
//     */
//    public function exchange($id): Response
//    {
//        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($id);
//        return $this->render('exchange/index.html.twig', [
//            'patient' => $patient
//        ]);
//    }

}
