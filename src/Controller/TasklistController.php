<?php
/**
 * Tasklist controller.
 */

namespace App\Controller;

use App\Entity\Tasklist;
use App\Form\TasklistType;
use App\Repository\TasklistRepository;
use App\Repository\TaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TasklistController.
 *
 * @Route("/tasklist")
 *
 * @IsGranted("ROLE_USER")
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
            $tasklistRepository->queryByAuthor($this->getUser()),
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
    public function show(Request $request, Tasklist $tasklist, TaskRepository $taskRepository, PaginatorInterface $paginator): Response
    {

            $pagination = $paginator->paginate(
                $taskRepository->findBy(['tasklist'=>$tasklist]),
                $request->query->getInt('page', 1),
                19
            );

            return $this->render(
            'tasklist/show.html.twig',
            [
                'pagination' => $pagination,
                'tasklist' => $tasklist
            ]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\TasklistRepository            $tasklistRepository     Tasklist repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="tasklist_create",
     * )
     */
    public function create(Request $request, TasklistRepository $tasklistRepository): Response
    {
        $tasklist = new Tasklist();
        $form = $this->createForm(TasklistType::class, $tasklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tasklist->setAuthor($this->getUser());
            $tasklistRepository->save($tasklist);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('tasklist_index');
        }

        return $this->render(
            'tasklist/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Tasklist                      $tasklist           Tasklist entity
     * @param \App\Repository\TasklistRepository        $tasklistRepository Tasklist repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="tasklist_edit",
     * )
     */
    public function edit(Request $request, Tasklist $tasklist, TasklistRepository $tasklistRepository): Response
    {
        $form = $this->createForm(TasklistType::class, $tasklist, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$task->setUpdatedAt(new \DateTime());
            $tasklistRepository->save($tasklist);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('tasklist_index');
        }

        return $this->render(
            'tasklist/edit.html.twig',
            [
                'form' => $form->createView(),
                'tasklist' => $tasklist,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Tasklist                      $tasklist           Tasklist entity
     * @param \App\Repository\TasklistRepository        $tasklistRepository Tasklist repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="tasklist_delete",
     * )
     */
    public function delete(Request $request, Tasklist $tasklist, TasklistRepository $tasklistRepository): Response
    {
        $form = $this->createForm(TasklistType::class, $tasklist, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $tasklistRepository->delete($tasklist);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('tasklist_index');
        }

        return $this->render(
            'tasklist/delete.html.twig',
            [
                'form' => $form->createView(),
                'tasklist' => $tasklist,
            ]
        );
    }
}