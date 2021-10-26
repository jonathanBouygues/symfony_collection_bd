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
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\UserRepository;
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
    public function index(BandeDessineeRepository $bandeDessineeRepository, EditorRepository $editorRepository, AuthorRepository $authorRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'Administration',
            'bande_dessinees' => $bandeDessineeRepository->findAll(),
            'editors' => $editorRepository->findAll(),
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user_all", name="user_all")
     */
    public function userAll(UserRepository $userRepository): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'controller_name' => 'Inscrit',
            'users' => $userRepository->findAll(
                ['name' => 'ASC']
            ),
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

            // Manage the uploaded image
            $bandeDessinee = $this->manageImage($bandeDessinee, $form);
            // inject un DB
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

            $bandeDessinee = $this->manageImage($bandeDessinee, $form);

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


    private function manageImage($bandeDessinee, $form)
    {
        // DELETE OLD IMAGE
        if (!is_null($bandeDessinee->getImage())) {
            // Get data
            $oldImage = $bandeDessinee->getImage();
            // Delete in the directory
            unlink($this->getParameter('image_directory') . '/' . $oldImage);
        }

        // MANAGE UPLOAD
        // Get data
        $image = $form->get('image')->getData();
        // Generate the uudi
        $fichier = md5(uniqid()) . '.' . $image->guessExtension();
        // Copie the file in the directory "uploads"
        $image->move(
            $this->getParameter('image_directory'),
            $fichier
        );
        // Modifie l'objet BandeDessinee
        $bandeDessinee->setImage($fichier);

        return $bandeDessinee;
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


    // AUTHOR
    /**
     * @Route("/author/new", name="author_new", methods={"GET","POST"})
     */
    public function newAuthor(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/author/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/author/{id}", name="author_show", methods={"GET"})
     */
    public function showAuthor(Author $author): Response
    {
        return $this->render('admin/author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/author/{id}/edit", name="author_edit", methods={"GET","POST"})
     */
    public function editAuthor(Request $request, Author $author): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/author/{id}", name="author_delete", methods={"POST"})
     */
    public function deleteAuthor(Request $request, Author $author): Response
    {
        if ($this->isCsrfTokenValid('delete' . $author->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
