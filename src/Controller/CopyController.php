<?php

namespace App\Controller;

use App\Entity\Copy;
use App\Form\CopyType;
use App\Repository\CopyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/copy")
 */
class CopyController extends AbstractController
{
    /**
     * @Route("/", name="copy_index", methods={"GET"})
     */
    public function index(CopyRepository $copyRepository): Response
    {
        return $this->render('copy/index.html.twig', [
            'copies' => $copyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="copy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $copy = new Copy();
        $form = $this->createForm(CopyType::class, $copy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($copy);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($copy);
            $entityManager->flush();

            return $this->redirectToRoute('copy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('copy/new.html.twig', [
            'copy' => $copy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="copy_show", methods={"GET"})
     */
    public function show(Copy $copy): Response
    {
        return $this->render('copy/show.html.twig', [
            'copy' => $copy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="copy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Copy $copy): Response
    {
        $form = $this->createForm(CopyType::class, $copy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('copy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('copy/edit.html.twig', [
            'copy' => $copy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="copy_delete", methods={"POST"})
     */
    public function delete(Request $request, Copy $copy): Response
    {
        if ($this->isCsrfTokenValid('delete' . $copy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($copy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('copy_index', [], Response::HTTP_SEE_OTHER);
    }
}
