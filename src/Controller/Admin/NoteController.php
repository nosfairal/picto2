<?php

namespace App\Controller\Admin;

use App\Entity\Note;
use App\Entity\Patient;
use App\Form\NoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
    /**
     * @Route("admin/patient/note")
     */
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/{id}", name="patient_note")
     */
    public function index($id): Response
    {
        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($id);
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }
        $notes = $patient->getNotes();
        return $this->render('note/index.html.twig', [
            'patient' => $patient,
            'notes' => $notes
        ]);
    }

    /**
     * @Route("/ajout/{id}", name="add_note")
     */
    public function addNote(Request $request, $id): Response
    {
        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($id); // Trouve un patient par son ID

        // Si le patient n'existe pas, redirection vers la liste des patients
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }

        $note = new Note();
        $therapist = $this->getUser();

        $note->setCreatedAt(new \DateTime('now')); // Le champs date est automatiquement rempli par la date du jour
        $note->setTherapist($therapist); // Le champs thérapeute est automatiquement rempli par l'id du thérapeute connecté
        $note->setPatient($patient); // Le champs patient est automatiquement rempli par l'id du patient

        $patient->getNotes()->add($note);

        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, les données sont insérées en base de données
        if ($form->isSubmitted() && $form->isValid()) {
            $note = $form->getData();
            $this->entityManager->persist($note);
            $this->entityManager->flush();

            return $this->redirectToRoute('patient_note', ['id' => $id]);
        }
        return $this->render('note/add.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient
         ]);
    }
}
