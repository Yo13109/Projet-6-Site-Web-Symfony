<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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

    public function create()
    {
        $trick = new Trick;
        $form = $this->createFormBuilder($trick)
            ->add('name', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nom de la figure'
                ]
            ])
            ->add('content',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Contenu de la figure',

                ]
            ])
            ->add('category')
            ->getForm();

        return $this->render('blog/create.html.twig',[
            'formTrick'=>$form->createView()
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
    public function update()
    {
        return $this->render('blog/update.html.twig');
    }
}
