<?php

namespace App\Controller\User;

use App\Entity\Patient;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Controller\Admin\CategoryController;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pictogram;
use App\Form\SearchType;
use App\Classe\Search;
use App\Form\CreateCategoryType;
use App\Form\CreatePictogramType;
use App\Repository\PictogramRepository;
use Symfony\Component\HttpFoundation\Request;

class DialogueController extends AbstractController
{
    
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/admin/user/dialogue/{id}", name="dialogue")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index1($id,CategoryRepository $repository, PictogramRepository $pictogramRepository, QuestionRepository $questionRepository): Response
    {
        $patient = $this->em->getRepository(Patient::class)->findOneById($id);
        if (!$patient) {

            return $this->redirectToRoute('patient');
        }

        $categories = $repository->findAll();
        $pictos = $pictogramRepository->findAll();
        $questions=$questionRepository->findAll();
        return $this->render('dialogue/index.html.twig', [
            'patient' => $patient,
            'categories' => $categories,
            'pictos' => $pictos,
            'questions'=>$questions
        ]);
    }
}
