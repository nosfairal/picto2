<?php

namespace App\Controller\GuestMode;

use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PictogramRepository;

class GuestModeController extends AbstractController
    /**
     * @Route("guest")
     */
{
    /**
     * @Route("/", name="guest")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/echange", name="guest_exchange")
     */
    public function exchangeGuest(CategoryRepository $repository,PictogramRepository $pictogramRepository): Response
    {
        $categories = $repository->findAll();
        $pictos = $pictogramRepository->findAll();
        return $this->render('exchange/index.html.twig', [
            'categories' => $categories,
            'pictos' => $pictos
        ]);
    }

    /**
     * @Route("/dialogue", name="guest_dialogue")
     */
    public function dialogueGuest(CategoryRepository $repository,PictogramRepository $pictogramRepository, QuestionRepository $questionRepository): Response
    {
        $categories = $repository->findAll();
        $pictos = $pictogramRepository->findAll();
        $questions=$questionRepository->findAll();

        return $this->render('dialogue/index.html.twig',[
            'categories' => $categories,
            'pictos' => $pictos,
            'questions'=>$questions
        ]);
    }
    /**
     * @Route("/game", name="guest_game")
     */
    public function GameGuest(CategoryRepository $repository,PictogramRepository $pictogramRepository): Response
    {
        $categories = $repository->findAll();
        $pictos = $pictogramRepository->findAll();
        return $this->render('game/index.html.twig', [
            'categories' => $categories,
            'pictos' => $pictos,
        ]);
    }
}
