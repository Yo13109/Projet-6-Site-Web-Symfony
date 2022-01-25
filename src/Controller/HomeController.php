<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Picture;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Entity\Commentary;
use App\Form\PictureType;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use App\Repository\CommentaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @method Annonces[] findBy()
 */
class HomeController extends AbstractController
{
    protected $slugger;



    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $this->em = $em;
        $this->slugger = $slugger;
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
                'pagesuivante' => $page + 1,
                'limit' => $limit,
                'totaltricks' => $tricksCount,
            ]
        );
    }
   

}
