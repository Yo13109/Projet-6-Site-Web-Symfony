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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @method Annonces[] findBy()
 * 
 */
class HomeController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @var \App\Entity\Trick $tricks
     * @Route("/", name="home")
     */
    public function index(TrickRepository $trickRepository, Request $request): Response
    {


        $page = $request->query->getInt('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
        $nbperpage = $this->getParameter('app.nbperpage');
        $limit = $nbperpage * $page;
        $tricks = $trickRepository->findBy([], ['createDate' => 'asc'], $limit, 0);
        $tricksCount = count($trickRepository->findAll());
        
        
        return $this->render(
            'home/home.html.twig',
            [
                'tricks' => $tricks,
                'pagesuivante'=>$page+1,
                'limit'=>$limit,
                'totaltricks'=>$tricksCount,
            ]
        );
    }
    /**
     * 
     * @Route("/blog/new", name="create_figure")
     */

    public function create(Request  $request,Trick $trick, EntityManagerInterface $em,$slug)
    {

        $repo = $this->getDoctrine()
        ->getRepository(Trick::class);

    $trick = $repo->find($slug);
    
    $form = $this->createForm(TrickType::class, $trick);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $trick->setCreateDate(new DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($trick);
        $em->flush();

        return $this->redirectToRoute('show_figure', ['slug' => $trick->getSlug()]);
    }
                
        return $this->render('home/create.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }
    /**
     * @param UserRepository $users
     * @param User $user
     * @param CommentaryRepository $comments
     * @param TrickRepository $trick
     * @Route("/blog/{slug}", name="show_figure")
     */


    public function show(Trick $trick, CommentaryRepository $commentaryRepository,  Request $request, EntityManagerInterface $em,TokenStorageInterface $token)
    {

       

        $page = $request->query->getInt('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
        $nbperpage = $this->getParameter('app.cmtperpage');
        $limit = $nbperpage * $page;
       // $repo = $this->getDoctrine()->getRepository($trick);

       // $comments = $repo->findBy([], ['date' => 'desc'], $limit, 0);
        $commentCount = count($trick->getComments());
        dd($commentCount);
        

        

        $comment = new Commentary;

        $form = $this->createForm(CommentType::class, $comment);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $token->getToken();
            $user= $user->getUser();
            $comment
                ->setDate(new DateTime())
                ->setTrick($trick)
                ->setUser($user);
                


            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('show_figure', ['slug' => $trick->getSlug()]);
        }

        return $this->render('home/show.html.twig', [

            'trick' => $trick, 'formComment' => $form->createView(),
            'pagesuivante'=>$page+1,
                'limit'=>$limit,
                'totalComment'=>$commentCount,
                



        ]);
    }

    /**
     * @Route("/blog/update/{slug}", name="update_figure")
     */
    public function update(Trick $trick, Request $request, EntityManagerInterface $em, $slug)
    {
        $repo = $this->getDoctrine()
            ->getRepository(Trick::class);

        $trick = $repo->find($slug);


        

        $form = $this->createForm(TrickType::class, $trick);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreateDate(new DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            return $this->redirectToRoute('show_figure', ['slug' => $trick->getSlug()]);
        }
        return $this->render('home/update.html.twig', [
            'formUpdateTrick' => $form->createView(),
            'trick' => $trick
        ]);
    }
    /**
     * @return RedirectResponse
     * @Route("/blog/{slug}/delete", name="delete_figure")
     * @param Trick $trick
     */
    public function delete(Trick $trick): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($trick);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
