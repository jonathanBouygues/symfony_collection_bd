<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Copy;
use App\Form\CopyType;
use App\Form\EditProfilType;
use App\Repository\CopyRepository;
use App\Repository\UserRepository;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/editProfile", name="edit_profile", methods={"GET","POST"})
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/editProfile.html.twig', [
            'controllerName' => 'Modification du profil',
            'user' => $user,
            'form' => $form,
        ]);
    }


    // COPY
    /**
     * @Route("/copy", name="copy_index", methods={"GET"})
     */
    public function indexCopy(CopyRepository $copyRepository): Response
    {
        // Get the userID
        $userId = $this->getUser()->getId();

        return $this->render('user/copy/index.html.twig', [
            'controller_name' => 'Ma collection',
            'copies' => $copyRepository->findBy(
                ['user' => $userId]
            ),
        ]);
    }

    /**
     * @Route("/addCopy", name="copy_new", methods={"GET","POST"})
     */
    public function newCopy(Request $request): Response
    {

        $copy = new Copy();
        $form = $this->createForm(CopyType::class, $copy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $copy->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($copy);
            $entityManager->flush();

            return $this->redirectToRoute('copy_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/copy/new.html.twig', [
            'controllerName' => 'Nouvelle Entrée',
            'copy' => $copy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="copy_show", methods={"GET"})
     */
    public function show(Copy $copy): Response
    {
        return $this->render('user/copy/show.html.twig', [
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

        return $this->renderForm('user/copy/edit.html.twig', [
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
