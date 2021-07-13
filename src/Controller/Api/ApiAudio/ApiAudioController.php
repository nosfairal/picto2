<?php

namespace App\Controller\Api\ApiAudio;

use App\Entity\Patient;
use App\Entity\Sentence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ApiAudioController extends AbstractController
{
    /**
     * @Route("/api/audio/{id}", name="api_audio", methods={"POST"})
     * @param $id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index($id, Request $request, EntityManagerInterface $em): Response
    {

        $patient = $em->getRepository(Patient::class)->findOneById($id);
        if (!$patient) {
            return $this->redirectToRoute('patient');
        }

        $file = $request->files->get('file');

        $audioFile = md5(uniqid()).'.'.$file->guessExtension();

        $file->move(
            $this->getParameter('audio_directory'),
            $audioFile
        );

        $sentence = new Sentence();
        $sentence->setCreatedAt(new \DateTime('now'));
        $sentence->setPatient($patient);
        $patient->getSentences()->add($sentence);
        $sentence->setAudio($audioFile);

        $em->persist($sentence);
        $em->flush();

        return $this->json($sentence, 201, [], ['groups'=>'sentence:read']);
    }
}