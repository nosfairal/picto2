<?php

namespace App\Controller\Admin;

use App\Form\EditPasswordTherapistType;
use App\Form\EditTherapistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
    /**
     * @Route("/admin")
     */
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/modification", name="admin_edit")
     */
    public function editTherapist(Request $request): Response
    {
        $therapist = $this->getUser();

        $form = $this->createForm(EditTherapistType::class, $therapist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $therapist = $form->getData();
            $this->entityManager->flush();

//            dd($therapist);
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mail-modification-mot-de-passe", name="mail_password")
     */
    public function mailPassword(): Response
    {
        return $this->render('admin/mailPassword.html.twig');
    }

    /**
     * @Route("/modification-mot-de-passe", name="edit_password")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notificationWarning = null;
        $notificationSuccess=null;
        $therapist = $this->getUser();
        $form = $this->createForm(EditPasswordTherapistType::class, $therapist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if ($encoder->isPasswordValid($therapist, $oldPassword)) {
                //die('cool!');
                $newPassword = $form->get('newPassword')->getData();
                $password = $encoder->encodePassword($therapist, $newPassword);

                $therapist->setPassword($password);
                $this->entityManager->flush();
                $this->addFlash('success', 'Mot de passe modifié avec succès');
                return $this->redirectToRoute('app_login');
            } else {
                $notificationWarning = "Le mot de passe actuel est incorrect.";
            }
        }


        return $this->render('admin/editPassword.html.twig', [
            'form' => $form->createView(),
            'notificationSuccess' => $notificationSuccess,
            'notificationWarning' =>$notificationWarning
        ]);

    }
}
