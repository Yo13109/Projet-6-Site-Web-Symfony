<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
       
        return $this->render('blog/home.html.twig' );
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
