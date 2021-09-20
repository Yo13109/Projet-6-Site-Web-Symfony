<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

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

        return $this->render('security/login.html.twig', []);
    }

    /**
     * @Route("/deconnexion", name="security_deconnexion")
     */
    public function logout()
    {

    
    }
}
