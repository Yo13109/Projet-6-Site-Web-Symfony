<?php

namespace App\Controller;


use DateTime;
use App\Entity\User;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Entity\Commentary;
use App\Repository\TrickRepository;
use App\Repository\CommentaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BlogController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Trick::class)
            ->findAll();

        return $this->render(
            'blog/home.html.twig',
            [
                'controller_name' => 'BlogController',
                'tricks' => $tricks

            ]
        );
    }
   
    /**
     * @Route("/blog/new", name="create_figure")
     */

    public function create(Request  $request, EntityManagerInterface $em)
    {
        $trick = new Trick;
        $form = $this->createForm(TrickType::class, $trick);
        


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreateDate(new DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();
        }
        return $this->render('blog/create.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }
    /**
     * @param UserRepository $users
     * @param User $user
     * @param CommentaryRepository $comments
     * @param TrickRepository $trick
     * @Route("/blog/{id}", name="show_figure")
     */

    public function show($id, Trick $trick,  Request $request, EntityManagerInterface $em)

    {
        $comments=$this->getDoctrine()
                        ->getRepository(Commentary::class)
                        ->find($id);
        

            $user = $this->getDoctrine()->getRepository(User::class)->find($id);            
            $comment = new Commentary;

            $form = $this->createForm(CommentType::class, $comment);
    
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $comment->setDate(new DateTime())
                        ->setTrick($trick)
                        ->setUser($user);
                        
                $em->persist($comment);
                $em->flush();
            return $this->redirectToRoute('show_figure', ['id'=>$trick->getId(),'id'=>$user->getId()]);
            }
        
        return $this->render('blog/show.html.twig', [
             'trick' => $trick,'formComment' => $form->createView(),'comment' => $comments
           
        ]);
    }

    /**
     * @Route("/blog/update/{id}", name="update_figure")
     */
    public function update(Trick $trick , Request $request, EntityManagerInterface $em,$id)
    {
        $repo = $this->getDoctrine()
            ->getRepository(Trick::class);

            $trick = $repo->find($id);

        




        $form = $this->createForm(TrickType::class, $trick);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreateDate(new DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            return $this->redirectToRoute('show_figure', ['id'=> $trick->getId()]);
        }
        return $this->render('blog/update.html.twig', [
            'formUpdateTrick' => $form->createView(),
            'trick' => $trick
        ]);
                  
    }
    /**
     * @return RedirectResponse
     * @Route("/blog/{id}/delete", name="delete_figure")
     * @param Trick $trick
     */
    public function delete(Trick $trick):RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($trick);
        $em->flush();

        return $this->redirectToRoute('home');

    }
}
