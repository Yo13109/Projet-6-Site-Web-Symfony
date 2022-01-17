<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Services\Mailer;
use Doctrine\ORM\EntityManager;
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
    public function registration(Request $request, Mailer $mailer, EntityManager $em)
    {
        $mailer = $this->mailer;
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setActivated(1)
                ->setPassword($this->passwordHasher->hashPassword($user, $form->get('password')->getData()));
            $user->setToken('ggtgltrp^prlf');

            $em->persist($user);
            $em->flush();

            $this->mailer->sendEmail($user->getEmail(), $user->getToken());
            return $this->redirectToRoute('security_connexion');
        }
        return $this->render('security/registration.html.twig', [
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_connexion")
     */
    public function login()
    {
        
        $this->addFlash('se connecter', "Vous vous êtes connecté avec succès!");
        $this->addFlash('non connecter', "Votre mot de passe est incorrect!");
        return $this->render('security/login.html.twig', []);
    }

    /**
     * @Route("/deconnexion", name="security_deconnexion")
     */
    public function logout()
    {
        $this->addFlash('deconnexion', "Vous êtes déconnecté!");
        return $this->render('home');
    }
    
}
