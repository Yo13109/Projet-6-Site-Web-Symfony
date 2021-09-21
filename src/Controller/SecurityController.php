<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Services\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher, Mailer $mailer)
     {
         $this->passwordHasher = $passwordHasher;
         $this->mailer = $mailer;

         
     }

    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, Mailer $mailer)
    {
        $mailer = $this->mailer;
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        $random = random_bytes(10);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setActivated(1)
                 ->setPassword($this->passwordHasher->hashPassword($user, $form->get('password')->getData()));
                 
            $user->setToken('ggtgltrp^prlf');

           
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
           
            $this->mailer->sendEmail($user->getEmail(),$user->getToken());

            return $this->redirectToRoute('security_connexion');
        }

        return $this->render('security/registration.html.twig', [
            'formUser' => $form->createView()
        ]);
    }
/**
 * @Route("/confirmer_compte/{token}" name="confirm_compte")
 *@param string $token
 * @return \Symfony\Component\HttpFoundation\JsonResponse
 */
        public function confirm_inscription( string $token){



            return $this->json($token);
        }




    /**
     * @Route("/login", name="security_connexion")
     */
    public function login()
    {

        return $this->render('security/login.html.twig', []);
    }

    /**
     * @Route("/deconnexion", name="security_deconnexion")
     */
    public function logout()
    {

    
    }
}
