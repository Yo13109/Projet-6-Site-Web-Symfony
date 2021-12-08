<?php

namespace App\Controller;


use DateTime;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Picture;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Entity\Commentary;
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


/**
 * @method Annonces[] findBy()
 * 
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
    /**
     * 
     * @Route("/blog/new", name="create_figure")
     */

    public function create(Request  $request, EntityManagerInterface $em)
    {

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('pictures')->getData();
            foreach ($images as $image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $fileName = $safeFilename . '-' . md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('app.image.directory'), $fileName);

                $picture = new Picture();
                $picture->setFilename($fileName)
                        ->setMain('0');
                $trick->addPicture($picture);
            }

            $user =  $this->getUser();
            $trick->setCreateDate(new DateTime())
                    ->setUpdateDate(new DateTime())
                    ->setSlug($this->slugger->slug($trick->getName()))
                    ->setUsers($user);
                    
                    

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


    public function show(Trick $trick, CommentaryRepository $commentaryRepository,  Request $request, EntityManagerInterface $em)
    {



        $page = $request->query->getInt('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
        $nbperpage = $this->getParameter('app.cmtperpage');
        $limit = $nbperpage * $page;


        $comments = $commentaryRepository->findBy(['trick' => $trick], ['date' => 'desc'], $limit, 0);
        $commentCount = count($trick->getComments());






        $comment = new Commentary;

        $form = $this->createForm(CommentType::class, $comment);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
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
            'pagesuivante' => $page + 1,
            'limit' => $limit,
            'totalComment' => $commentCount,
            'comments' => $comments,




        ]);
    }

    /**
     * @Route("/blog/update/{slug}", name="update_figure")
     */
    public function update(Request $request, EntityManagerInterface $em, string $slug)
    {
        //  $repo = $this->getDoctrine()
        // ->getRepository(Trick::class);
        $repo = $em->getRepository(Trick::class);

        $trick = $repo->findOneBy(['slug' => $slug]);


        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('pictures')->getData();
            foreach ($images as $image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $fileName = $safeFilename . '-' . md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('app.image.directory'), $fileName);
                $picture = new Picture();
                $picture->setFilename($fileName)
                        ->setMain('0');
                $trick->addPicture($picture);
    }

            $trick->setCreateDate(new DateTime())
                ->setSlug($this->slugger->slug($trick->getName()));
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

     /**
     * @return RedirectResponse
     * @Route("/blog/{slug}/deleteImage", name="delete_image")
     * @param Trick $trick
     */
    public function deleteImage(Picture $picture): RedirectResponse
    {
        unlink($this->getParameter('app.image.directory'));
        $em = $this->getDoctrine()->getManager();
        $em->remove($picture);
        $em->flush();

        return $this->redirectToRoute('update_figure');
    }
}
