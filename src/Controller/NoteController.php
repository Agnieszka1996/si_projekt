<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NoteController.
 *
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\NoteRepository            $noteRepository Note repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="note_index",
     * )
     */
    public function index(Request $request, NoteRepository $noteRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $noteRepository->queryAll(),
            $request->query->getInt('page', 1),
            NoteRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'note/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Note $note Note entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="note_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Note $note): Response
    {
        return $this->render(
            'note/show.html.twig',
            ['note' => $note]
        );
    }
}