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
class TrickController extends AbstractController
{
    protected $slugger;



    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $this->em = $em;
        $this->slugger = $slugger;
    }

    /**
     * @Route("/blog/new", name="create_figure")
     */
    public function create(Request $request, EntityManagerInterface $em)
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

            $this->addFlash('message', "la figure  {$trick->getName()} a été créée avec succès! ");

            return $this->redirectToRoute('home');
        }

        return $this->render('home/create.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }
    /**
     * @Route("/blog/{slug}", name="show_figure")
     */


    public function show(Trick $trick, Request $request, EntityManagerInterface $em)
    {
        $page = $request->query->getInt('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
        $nbperpage = $this->getParameter('app.cmtperpage');
        $limit = $nbperpage * $page;
        $comments = $em->getRepository(Commentary::class)->findBy(['trick' => $trick], ['date' => 'desc'], $limit, 0);
        $commentCount = count($trick->getComments());
        $comment = new Commentary();
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
                    ->setMain(false);
                $trick->addPicture($picture);
            }

            $trick->setCreateDate(new DateTime())
                ->setSlug($this->slugger->slug($trick->getName()));
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
     * @Route("/blog/{slug}/delete", name="delete_figure")
     */
    public function delete(Trick $trick, EntityManagerInterface $em): RedirectResponse
    {
        
        foreach ($trick->getPictures() as $image) {
            unlink($this->getParameter('app.image.directory') . '/' . $image->getFilename());
        }
        $em->remove($trick);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/blog/{id}/deleteImage", name="delete_image")
     */
    public function deleteImage(Picture $picture, EntityManagerInterface $em)
    {


        $nom = $picture->getFilename();
        unlink($this->getParameter('app.image.directory') . '/' . $nom);


        $em->getRepository(Picture::class);
        $em->remove($picture);
        $em->flush();


        return $this->redirectToRoute('home');
        //return $this->redirectToRoute('update_figure', ['slug' => $picture->getTricks()->getSlug()]);
    }
    /**
     * @Route("/toto/{id}", name="main_image")
     */
    public function mainImage(Picture $picture, EntityManagerInterface $em)
    {
        $picture->setMain(true);
        $em->flush();

        return $this->redirectToRoute('update_figure', ['slug' => $picture->getTricks()->getSlug()]);
    }
}
