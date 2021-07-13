<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/index.html.twig');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/mentionsLegales", name="mentions")
     */
    public function mentions(){
        return $this->render('mentionsLegales/mentionsLegales.html.twig');
    }

    /**
     * @Route("/aPropos", name="a_propos")
     */
    public function aPropos(){
        return $this->render('annexes/aPropos.html.twig');
    }

    /**
     * @Route("/partenaires", name="partners")
     */
    public function partners(){
        return $this->render('annexes/partners.html.twig');
    }
}