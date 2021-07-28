<?php

namespace App\Controller\Admin;

use App\Entity\Note;
use App\Form\DeleteAccount;
use App\Form\EditPasswordTherapistType;
use App\Form\EditTherapistType;
use App\Repository\NoteRepository;
use App\Repository\PatientRepository;
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

    /**
     * @Route("/suppression-du-compte", name="delete_user_form")
     */

    public function deleteAccount(Request $request, UserPasswordEncoderInterface $encoder, NoteRepository $noteRepository, PatientRepository $patientRepository){

        $notificationWarning = null;
        $notificationSuccess=null;
        $therapist = $this->getUser();
        $id = $therapist->getId();
        $form = $this->createForm(DeleteAccount::class, $therapist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('Password')->getData();
            if ($encoder->isPasswordValid($therapist, $password)) {
                
                $therapist->setEmail('Thérapeute désactivé numéro ' . $id);
                $therapist->setFirstName('Thérapeute désactivé numéro ' . $id);
                $therapist->setLastName('Thérapeute désactivé numéro ' . $id);
                $this->entityManager->flush();
                $this->addFlash('success', 'Mot de passe modifié avec succès');
                return $this->redirectToRoute('app_logout');
            } else {
                $notificationWarning = "Le mot de passe est incorrect.";
            }
        }
        return $this->render('admin/deleteAccount.html.twig', [
            'form' => $form->createView(),
            'notificationSuccess' => $notificationSuccess,
            'notificationWarning' =>$notificationWarning
        ]);
    }

}
