<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use App\Entity\Sentence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AudioController extends AbstractController
{
    private $entityManager;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;

    }


    /**
     * @Route("admin/user/spectrogram/{id}", name="admin_spectrogram")
     * @param Sentence $sentence
     * @return Response
     */
    public function spectrogram(Sentence $sentence): Response
    {
        $patientId = $this->session->get('patientId');
        $patient = $this->entityManager->getRepository(Patient::class)->findOneById($patientId);
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }
        return $this->render('audio/spectrogram.html.twig', [
            "sentence" => $sentence,
            "patient" => $patient,
        ]);
    }

    /**
     * @Route("/admin/user/audio/{id}/delete", name="admin_audio_delete", methods="DELETE")
     * @param Sentence $sentence
     * @param Request $request
     */
    public function delete(Sentence $sentence, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $audio = $sentence->getAudio();
        if($this->isCsrfTokenValid('delete' . $sentence->getId(), $request->get('_token'))){
            $this->entityManager->remove($sentence);
            $this->entityManager->flush();
            unlink($this->getParameter('audio_directory').'/'.$audio);
            $this->addFlash('success', 'Enregistrement audio supprimé avec succès.');
        };

        return $this->redirectToRoute('patient_sentence', ['id' => $this->session->get('patientId')]);

    }
}
