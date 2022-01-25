<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Mailer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

      //  $this->addFlash('se connecter', "Vous vous êtes connecté avec succès!");
        //$this->addFlash('non connecter', "Votre mot de passe est incorrect!");

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
     /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, Mailer $mailer, EntityManagerInterface $em)
    {
        //$mailer = $this->mailer;
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
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/registration.html.twig', [
            'formUser' => $form->createView()
        ]);
    }
}
