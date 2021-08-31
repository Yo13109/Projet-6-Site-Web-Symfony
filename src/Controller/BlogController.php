<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;
use DateTime;
use Symfony\Component\HttpFoundation\Request;




class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Trick::class);
        $tricks = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController', 'tricks' => $tricks
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $repo = $this->getDoctrine()->getRepository(Trick::class);
        $tricks = $repo->findAll();
        return $this->render(
            'blog/home.html.twig',
            ['tricks' => $tricks]

        );
    }
    /**
     * @Route("/blog/new", name="create_figure")
     */

    public function create(Request  $request)
    {
        $trick = new Trick;
        $form = $this->createFormBuilder($trick)
            ->add('name')
            ->add('content')
            ->add('category')
            ->add('video')
            ->getForm();

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
    public function show()
    {
        return $this->render('blog/show.html.twig');
    }

    /**
     * @Route("/blog/update", name="update_figure")
     */
    public function update(Request $request)
    {
        $trick = new Trick;
        $trick ->setName('Yoann est arrivé')
               ->setContent('Yoann est arrivé ce matin');
              


        $form = $this->createFormBuilder($trick)
            ->add('name')
            ->add('content')
            ->add('category')
            ->add('video')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreateDate(new DateTime());
        }
        return $this->render('blog/update.html.twig',['formUpdateTrick'=>$form->createView()

        ]);
    }
}
