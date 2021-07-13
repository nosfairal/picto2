<?php

namespace App\Controller\Admin;

use App\Entity\Sentence;
use App\Entity\Patient;
use App\Form\AudioType;
use App\Form\SentenceType;
use App\Repository\SentenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SentenceController extends AbstractController
{
    /**
     * @Route("/admin/patient/sentence")
     * @param SentenceRepository $repository
     */
    /**
     * @var EntityManagerInterface
     */
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/admin/patient/sentence/{id}", name="patient_sentence")
     */
    public function index($id, SessionInterface $session): Response
    {
        $patient = $this->em->getRepository(Patient::class)->findOneById($id);
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }
        $session->set('patientId', $id);
        $sentences = $patient->getSentences();
        return $this->render('sentence/index.html.twig', [
            'patient' => $patient,
            'sentences' => $sentences
        ]);
    }
    /**
     * @Route("admin/user/echange/{id}", name="add_sentence")
     */
    public function addSentence(Request $request, $id): Response
    {
        $patient = $this->em->getRepository(Patient::class)->findOneById($id);
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }
        $sentence = new Sentence();
        //$therapist = $this->getUser();

        $sentence->setCreatedAt(new \DateTime('now'));
        //$note->setTherapist($therapist);
        $sentence->setPatient($patient);

        $patient->getSentences()->add($sentence);

        $formText = $this->createForm(SentenceType::class, $sentence);

        $formText->handleRequest($request);


        if ($formText->isSubmitted() && $formText->isValid()) {
            $sentence = $formText->getData();
//            dd($sentence);
            $this->em->persist($sentence);
            $this->em->flush();
            return $this->redirectToRoute('add_sentence',[
            'id' => $patient->getId()]);
        }

        return $this->render('exchange/index.html.twig', [
            'formText' => $formText->createView(),
            'patient' => $patient
        ]);
    }

}