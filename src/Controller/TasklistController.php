<?php
/**
 * Tasklist controller.
 */

namespace App\Controller;

use App\Entity\Tasklist;
use App\Repository\TasklistRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TasklistController.
 *
 * @Route("/tasklist")
 */
class TasklistController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\TasklistRepository            $tasklistRepository Tasklist repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="tasklist_index",
     * )
     */
    public function index(Request $request, TasklistRepository $tasklistRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $tasklistRepository->queryAll(),
            $request->query->getInt('page', 1),
            TasklistRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'tasklist/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Tasklist $tasklist Tasklist entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="tasklist_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Tasklist $tasklist): Response
    {
        return $this->render(
            'tasklist/show.html.twig',
            ['tasklist' => $tasklist]
        );
    }
}