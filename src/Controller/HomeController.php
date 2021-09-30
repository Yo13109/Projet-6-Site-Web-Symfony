<?php

namespace App\Controller;


use DateTime;
use App\Entity\User;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Entity\Commentary;
use App\Repository\TrickRepository;
use App\Repository\PictureRepository;
use App\Repository\CommentaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function index(TrickRepository $trickRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $data = $trickRepository->findBy([], ['createDate' => 'asc']);

       $tricks = $paginator->paginate(
        $data,
        $request->query->getInt('page',1),
        10,

       );
    
       $offset = max(0, $request->query->getInt('offset', 0));


        return $this->render(
            'home/home.html.twig',
            [
                'tricks' => $tricks,
                'previous'=> $offset - TrickRepository::PAGINATOR_PER_PAGE,
                'next'=>10+$offset + TrickRepository::PAGINATOR_PER_PAGE,
            ]
        );
    }
    /**
     * @var \App\Entity\Trick $tricks
     * @Route("/tricks20", name="home2")
     */
    public function index2(TrickRepository $trickRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $data = $trickRepository->findBy([], ['createDate' => 'asc']);

       $tricks = $paginator->paginate(
        $data,
        $request->query->getInt('page',1),
        20,

       );
    
       $offset = max(0, $request->query->getInt('offset', 0));


        return $this->render(
            'home/home#20.html.twig',
            [
                'tricks' => $tricks,
                'previous'=> $offset - TrickRepository::PAGINATOR_PER_PAGE,
                'next'=> 20+$offset + TrickRepository::PAGINATOR_PER_PAGE
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

   
    public function show(Trick $trick,  Request $request, EntityManagerInterface $em)
    {
        

        $comment = new Commentary;

        $form = $this->createForm(CommentType::class, $comment);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setDate(new DateTime())
                ->setTrick($trick)
            ;


            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('show_figure', ['slug' => $trick->getSlug()]);
        }

        return $this->render('home/show.html.twig', [
           
            'trick' => $trick, 'formComment' => $form->createView(),


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
