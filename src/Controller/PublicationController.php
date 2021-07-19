<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="publication_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="publication_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('publication/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="publication_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publication_index', [], Response::HTTP_SEE_OTHER);
    }
}
