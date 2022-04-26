<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trick;
use App\Form\RegistrationType;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Symfony\Component\DomCrawler\Form;
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

    public function __construct(UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
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
    public function registration(Request $request, EntityManagerInterface $em, MailerInterface $mailer, UserPasswordHasherInterface $passwordHasher)
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
                    $user,
                    $password
                )));



            $email = (new TemplatedEmail())
                ->from('yoann.corsi@gmail.com')
                ->to($user->getEmail())
                ->subject('Valider votre inscription')
                ->htmlTemplate('security/email.html.twig')
                ->context([
                    'token' => $user->getToken(),
                    'id' => $user->getId(),
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
     * @Route("/trick/compte_activ/{token}", name="compte_activ")
     */
    public function compteActiv(EntityManagerInterface $em, $token)
    {
        $user =  $this->userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $user->setActivated(true)
                ->setToken('');


            $em->persist($user);
            $em->flush();
            $this->addFlash('compte confirmé', 'Votre compte a été confirmé');
            return $this->redirectToRoute('home');
        } else {
            $this->addFlash('compte inexistant', "Votre compte a déjà été confirmé!");
            return $this->redirectToRoute('home');
        }




        return $this->redirectToRoute('home');
    }
    /**
     * @Route("/forgotPassword", name="forgot_password")
     */
    public function ForgotPassword(Request $request, EntityManagerInterface $em, MailerInterface $mailer)
    {
        $form = $this->createForm(ForgotPasswordType::class);
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user =  $this->userRepository->findOneBy([
                'email'=>$email,
                'activated'=> 1
            ]);
            dd($user, $email);
            $resetPasswordToken = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
            $user->setToken($resetPasswordToken);

            $email = (new TemplatedEmail())
                ->from('yoann.corsi@gmail.com')
                ->to($user->getEmail())
                ->subject('Regenerez votre mot de passe')
                ->htmlTemplate('security/forgot-email.html.twig')
                ->context([
                    'resetPasswordToken' => $user->getResetPasswordToken(),
                    'id' => $user->getId(),
                ]);
            $mailer->send($email);
            $em->persist($user);
            $em->flush();
            $this->addFlash('MailMessage', 'Un email vous a été envoyé');
            return $this->redirectToRoute('home');
        }
        return $this->render('security/forgotPassword.html.twig', [
            'form' => $form->createView()
        ]);

    }
    /**
     * @Route("/resetPassword/{resetForgotToken}", name="reset_password")
     */
    public function resetPassword(Request $request, EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher, $resetPasswordToken)
    {
        $user = $this->userRepository->findOneBy(['resetPasswordToken' => $resetPasswordToken]);
        if ($user) {
            $user->setActivated(true)
                ->setResetPasswordToken('');


        $form = $this->createForm(ResetPasswordType::class, $user);
    
        } else {
            $this->addFlash('Stop !', "Votre mot de passe a déjà été regénéré !");
            return $this->redirectToRoute('home');
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $user = $form->get('userName')->getData();
            $user->setPassword(($this->passwordHasher->hashPassword(
                $user,
                $password
            )));

        }
    }
}
