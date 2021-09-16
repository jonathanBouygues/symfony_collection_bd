<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\BandeDessinee;
use App\Form\BandeDessineeType;
use App\Repository\BandeDessineeRepository;
use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use App\Entity\Author;
use App\Form\AuthorEditorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(BandeDessineeRepository $bandeDessineeRepository, EditorRepository $editorRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'bande_dessinees' => $bandeDessineeRepository->findAll(),
            'editors' => $editorRepository->findAll(),
        ]);
    }

    // BANDE DESSINEE
    /**
     * @Route("/bandeDessinee/new", name="bande_dessinee_new", methods={"GET","POST"})
     */
    public function newBd(Request $request): Response
    {
        $bandeDessinee = new BandeDessinee();
        $form = $this->createForm(BandeDessineeType::class, $bandeDessinee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bandeDessinee);
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/bande_dessinee/new.html.twig', [
            'bande_dessinee' => $bandeDessinee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/bandeDessinee/{id}", name="bande_dessinee_show", methods={"GET"})
     */
    public function showBd(BandeDessinee $bandeDessinee): Response
    {
        return $this->render('admin/bande_dessinee/show.html.twig', [
            'bande_dessinee' => $bandeDessinee,
        ]);
    }

    /**
     * @Route("/bandeDessinee/{id}/edit", name="bande_dessinee_edit", methods={"GET","POST"})
     */
    public function editBd(Request $request, BandeDessinee $bandeDessinee): Response
    {
        $form = $this->createForm(BandeDessineeType::class, $bandeDessinee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/bande_dessinee/edit.html.twig', [
            'bande_dessinee' => $bandeDessinee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/bandeDessinee/{id}", name="bande_dessinee_delete", methods={"POST"})
     */
    public function deleteBd(Request $request, BandeDessinee $bandeDessinee): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bandeDessinee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bandeDessinee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    // EDITOR
    /**
     * @Route("/editor/new", name="editor_new", methods={"GET","POST"})
     */
    public function newEditor(Request $request): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editor);
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/editor/new.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/editor/{id}", name="editor_show", methods={"GET"})
     */
    public function showEditor(Editor $editor): Response
    {
        return $this->render('admin/editor/show.html.twig', [
            'editor' => $editor,
        ]);
    }

    /**
     * @Route("/editor/{id}/edit", name="editor_edit", methods={"GET","POST"})
     */
    public function editEditor(Request $request, Editor $editor): Response
    {
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/editor/edit.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/editor/{id}", name="editor_delete", methods={"POST"})
     */
    public function deleteEditor(Request $request, Editor $editor): Response
    {
        if ($this->isCsrfTokenValid('delete' . $editor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
