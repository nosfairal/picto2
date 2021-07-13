<?php

namespace App\Controller\SuperAdmin;

use App\Classe\Mail;
use App\Entity\Institution;
use App\Entity\Therapist;
use App\Form\InstitutionType;
use App\Repository\InstitutionRepository;
use App\Repository\TherapistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("superadmin/institution")
 */
class InstitutionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="institution_index", methods={"GET"})
     */
    public function index(InstitutionRepository $institutionRepository): Response
    {
        $notificationWarning=null;
        $notificationSuccess=null;
        return $this->render('institution/index.html.twig', [
            'institutions' => $institutionRepository->findAll(),
            'notificationWarning' => $notificationWarning,
            'notificationSuccess'=>$notificationSuccess

        ]);
    }

    /**
     * @Route("/new", name="institution_new", methods={"GET","POST"})
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $institution = new Institution();

        $notificationWarning = null;
        $notificationWarning2 = null;
        $notificationWarning3 = null;

        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search_email = $this->entityManager->getRepository(Institution::class)->findOneByEmail($institution->getEmail());
            $code = $this->entityManager->getRepository(Institution::class)->findOneByCode($institution->getCode());
            if (!$code) {
                if (!$search_email) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($institution);
                    $entityManager->flush();

                    $mail = new Mail();
                    $subject = 'Vous êtes enregistré!';
                    $title = 'Bienvenue sur PictoPicto ' . $institution->getName() . '!';
                    $content = "Vous êtes désormais inscrit!<br/> Afin que vos équipes puissent créer leur compte personnalisé n'oubliez pas de leur transmettre le code suivant:<br/><br/>" . $institution->getCode() . "<br/><br/>À bientôt!";
                    $button = 'Connectez-vous';
                    $mail->send($institution->getEmail(), $institution->getName(), $subject, $title, $content, $button);
                    return $this->redirectToRoute('institution_index');

                } else {
                    $notificationWarning2 = 'Cette adresse mail est déjà utilisée.';
                }
            } else {
                $notificationWarning = "Ce code a déjà été utilisé.";
            }

        }


        return $this->render('institution/new.html.twig', [
            'institution' => $institution,
            'form' => $form->createView(),
            'notificationWarning' => $notificationWarning,
            'notificationWarning2' => $notificationWarning2,
            'notificationWarning3' => $notificationWarning3
        ]);
    }

    /**
     * @Route("/{id}", name="institution_show", methods={"GET"})
     */
    public function show(Institution $institution): Response
    {
        return $this->render('institution/show.html.twig', [
            'institution' => $institution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="institution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Institution $institution): Response
    {

        $notificationWarning = null;
        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $search_email = $this->entityManager->getRepository(Institution::class)->findOneByEmail($institution->getEmail());
                if (!$search_email) {
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('institution_index');
                } else {
                    $notificationWarning = 'Cette adresse mail est déjà utilisée.';
                }
            }
        }

        return $this->render('institution/edit.html.twig', [
            'institution' => $institution,
            'form' => $form->createView(),
            'notificationWarning' => $notificationWarning
        ]);
    }


    /**
     * @Route("/{id}", name="institution_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Institution $institution, TherapistRepository $therapistRepository, InstitutionRepository $institutionRepository): Response
    {
        $notificationWarning=null;
        $id = $institution->getId();
        $therapist = $therapistRepository->findByInstitution($id);
//        dd($therapist);

        if (!empty ($therapist)) {
            $notificationWarning = "Des thérapeutes se sont déjà inscrit à cette institution. Vous ne pouvez pas la supprimer.";

        } else {
            if ($this->isCsrfTokenValid('delete' .$id, $request->request->get('_token'))) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($institution);
                $entityManager->flush();
                $this->addFlash('success', 'Institution supprimée avec succès');

                return $this->redirectToRoute('institution_index');
            }
        }

        return $this->render('institution/index.html.twig', [
            'institutions' => $institutionRepository->findAll(),
            'notificationWarning' => $notificationWarning

        ]);

    }


}