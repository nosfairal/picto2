<?php

namespace App\Controller\Admin;

use App\Classe\Search;
use App\Entity\Note;
use App\Entity\Patient;
use App\Form\EditPatientType;
use App\Form\PatientRegisterType;
use App\Form\SearchType;
use App\Repository\NoteRepository;
use App\Repository\SentenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
    /**
     * @Route("admin/patient")
     */
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="patient")
     */
    public function index(Request $request): Response
    {
        $search = new Search();
        $institution = $this->getUser()->getInstitution(); // Institution/Entreprise du thérapeute connecté
        $form = $this->createForm(SearchType::class, $search); // Formulaire de recherche
        $form->handleRequest($request);

        // Si le formulaire de recherche est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Cherche le ou les patients qui correspondent
            $patients = $this->entityManager->getRepository(Patient::class)->findWithSearch($search);
        } else {
            // Sinon cherche les patients enregistrés dans la même institution
            $patientsId = $this->entityManager->getRepository(Patient::class)->findByInstitution($institution);
            $patients = $this->entityManager->getRepository(Patient::class)->findByIds($patientsId);
        }

        return $this->render('patient/index.html.twig', [
            'patients' => $patients,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inscription", name="patient_register")
     */
    public function addPatient(Request $request): Response
    {
        $patient = new Patient(); // Appelle un nouveau Patient
        $note = new Note(); // Appelle une nouvelle note
        $therapist = $this->getUser(); // thérapeute = administrateur connecté

        // Le champ date est automatiquement rempli par la date du jour
        $note->setCreatedAt(new \DateTime('now'));
        // Le champ thérapeute est automatiquement rempli par le thérapeute connecté
        $note->setTherapist($therapist);
        // Le champs patient est automatiquement rempli par le patient en cours d'enregistrement
        $note->setPatient($patient);
        $patient->getNotes()->add($note);

        // Crée le formulaire d'enregistrement d'un patient
        $form = $this->createForm(PatientRegisterType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données entrées et les enregistre
            $patient = $form->getData();
            $this->entityManager->persist($patient);
            $this->entityManager->flush();

            // Redirige vers la liste des patients
            return $this->redirectToRoute('patient');
        }
        return $this->render('patient/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="patient_profile")
     */
    public function patientProfile($id, SentenceRepository $sentenceRepository, NoteRepository $noteRepository): Response
    {

        // Cherche un patient par son id
        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($id);
        $note=$noteRepository->findOneByPatient($patient);
        $sentence=$sentenceRepository->findByPatient($patient);

        // Si le patient n'existe pas
        if (!$patient) {
            // Redirige vers la liste des patients
            return $this->redirectToRoute('patient');
        }
        return $this->render('patient/profile.html.twig', [
            'patient' => $patient,
            'sentence'=>$sentence,
            'note'=>$note
        ]);
    }

    /**
     * @Route("/modification/{id}", name="patient_edit")
     */
    public function editPatient(Request $request, $id): Response
    {
        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($id);

        if (!$patient){
            return $this->redirectToRoute('patient');
        }

        $form = $this->createForm(EditPatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

//            dd($patient);
            return $this->redirectToRoute('patient_profile', ['id' => $id ]);
        }
        return $this->render('patient/edit.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient
        ]);
    }
}
