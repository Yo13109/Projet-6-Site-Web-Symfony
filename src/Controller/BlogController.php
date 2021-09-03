<?php

namespace App\Controller;


use DateTime;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Entity\Commentary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
'blog/home.html.twig',['controller_name' => 'BlogController',
  'tricks'=>$tricks

]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $tricks = $this->getDoctrine()
                      ->getRepository(Trick::class)
                      ->findAll();
        
        return $this->render(
            'blog/home.html.twig',['controller_name' => 'BlogController',
                'tricks'=>$tricks

]);
    }
    /**
     * @Route("/blog/new", name="create_figure")
     */

    public function create(Request  $request)
    {
        $trick = new Trick;
        $form = $this->createForm(TrickType::class,$trick);
           

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreateDate(new DateTime());
        }
        return $this->render('blog/create.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }
    /**
     * @Route("/blog/id
     * ", name="show_figure")
     */

    public function show(Request $request)
    
    {
        $comment = new Commentary;
        $form = $this->createForm(CommentType::class,$comment);
           

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDate(new DateTime());
        }
        return $this->render('blog/show.html.twig', [
            'formComment'=>$form->createView()
        ]);
    }

    /**
     * @Route("/blog/update", name="update_figure")
     */
    public function update(Request $request)
    {
        $trick = new Trick;
        $trick ->setName('Yoann est arrivé')
               ->setContent('Yoann est arrivé ce matin');
              


        $form = $this->createForm(TrickType::class,$trick);
           

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreateDate(new DateTime());
        }
        return $this->render('blog/update.html.twig',['formUpdateTrick'=>$form->createView()

        ]);
    }
}
