<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Media;
use App\Form\CommentType;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/media")
 */
class MediaController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="media_index", methods={"GET"})
     */
    public function index(MediaRepository $mediaRepository): Response
    {
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="media_new", methods={"GET","POST"})
     */
    public function new(Request $request, Slugger $slugger): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setSlug($slugger->sluggify($medium->getTitle()));
            $this->entityManager->persist($medium);
            $this->entityManager->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/new.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="media_show", methods={"GET"})
     */
    public function show(Media $medium, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $comment->setMedia($medium);
//            $comment->author($this->getUser());
//        }

        return $this->render('media/show.html.twig', [
            'form' => $form->createView(),
            'medium' => $medium,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="media_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Media $medium, Slugger $slugger): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setSlug($slugger->sluggify($medium->getTitle()));
            $this->entityManager->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="media_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Media $medium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medium->getSlug(), $request->request->get('_token'))) {
            $this->entityManager->remove($medium);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('media_index');
    }
}
