<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Institution;
use App\Entity\Therapist;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }
        $notificationWarning = null;
        $notificationWarning2=null;
        $therapist = new Therapist();

        $form = $this->createForm(RegisterType::class, $therapist);
        $form->handleRequest($request);
        $institutionName = $form->get('institution')->getData();
        $institutionCode = $form->get('institutionCode')->getData();
        $institution = $this->entityManager->getRepository(Institution::class)->findOneById($institutionName);

        if ($form->isSubmitted() && $form->isValid()) {

            $therapist = $form->getData();

            $search_email=$this->entityManager->getRepository(Therapist::class)->findOneByEmail($therapist->getEmail());

            if(!$search_email){
                $password = $encoder->encodePassword($therapist, $therapist->getPassword());
                $therapist->setPassword($password);

                if ($institutionCode === $institution->getCode()) {
                    $this->entityManager->persist($therapist);
                    $this->entityManager->flush();

                    $mail=new Mail();
                    $subject='Confirmation de votre inscription';
                    $title='Bienvenue sur PictoPicto '.$therapist->getFirstName().'!';
                    $content='Votre inscription a bien été prise en compte. Vous pouvez dès à présent vous connecter.';
                    $button='Connectez-vous';
                    $mail->send($therapist->getEmail(),$therapist->getFirstName(),  $subject,$title,$content,$button);
                    return $this->redirectToRoute('register_confirmation');
                } else {
                    $notificationWarning = 'Le code entreprise est incorrect.';
                }
            }else{
                $notificationWarning2 = 'Cette adresse mail est déjà utilisée.';
            }


//            dd($institution);
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notificationWarning' => $notificationWarning,
            'notificationWarning2'=>$notificationWarning2
        ]);
    }

    /**
     * @Route("/inscription/confirmation", name="register_confirmation")
     */
    public function registerConfirmation(): Response
    {
        return $this->render('register/confirmation.html.twig');
    }
}
