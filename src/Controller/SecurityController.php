<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trick;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController

{

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
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
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $em, MailerInterface $mailer,UserPasswordHasherInterface $passwordHasher)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $user = new User;
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
            $user->setActivated(false)
                ->setToken($token)
                ->setPassword(($this->passwordHasher->hashPassword(
                    $user,$password
                )));

            

            $email = (new TemplatedEmail())
                ->from('yoann.corsi@gmail.com')
                ->to($user->getEmail())
                ->subject('Valider votre inscription')
                ->htmlTemplate('security/email.html.twig')
                ->context([
                    'token' => $user->getToken(),
                    'id' => $user->getId()
                ]);
            $mailer->send($email);

            $em->persist($user);
            $em->flush();
            $this->addFlash('MailMessage', 'Un email vous a été envoyé');
            return $this->redirectToRoute('home');
        }


        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/blog/{id}/compte_activ", name="compte_activ")
     */
    public function compteActiv(Trick $trick, EntityManagerInterface $em)
    {
        $trick->getUsers()->setActivated(true);
        $em->flush();

        return $this->redirectToRoute('home', [
            'trick' => $trick
            
        ]);
    }
}
