<?php
/**
 * Task controller.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Task;
use App\Form\CommentType;
use App\Form\TaskType;
use App\Service\CommentService;
use App\Service\TaskService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * Task service.
     *
     * @var \App\Service\TaskService
     */
    private $taskService;

    /**
     * Comment service.
     *
     * @var \App\Service\CommentService
     */
    private $commentService;

    /**
     * TaskController constructor.
     *
     * @param \App\Service\TaskService    $taskService    Task service
     * @param \App\Service\CommentService $commentService Comment service
     */
    public function __construct(TaskService $taskService, CommentService $commentService)
    {
        $this->taskService = $taskService;
        $this->commentService = $commentService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="task_index",
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->taskService->createPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $request->query->getAlnum('filters', [])
        );

        return $this->render(
            'task/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Task                          $task    Task entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET", "POST"},
     *     name="task_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @Security(
     *     "is_granted('ROLE_ADMIN') or is_granted('VIEW', task)"
     * )
     */
    public function show(Request $request, Task $task): Response
    {
        /*if ($task->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('task_index');
        }*/

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTask($task);

            $this->commentService->save($comment);

            $this->addFlash('success', 'comment_created_successfully');

            $id = $task->getId();

            return $this->redirectToRoute('task_show', ['id' => $id]);
        }

        return $this->render(
            'task/show.html.twig',
            [
                'task' => $task,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="task_create",
     * )
     */
    public function create(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setAuthor($this->getUser());
            $this->taskService->save($task);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'task/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Task                          $task    Task entity
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
     *     name="task_edit",
     * )
     *
     * @Security(
     *     "is_granted('ROLE_ADMIN') or is_granted('EDIT', task)"
     * )
     */
    public function edit(Request $request, Task $task): Response
    {
        /*if ($task->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('task_index');
        }
*/
        $form = $this->createForm(TaskType::class, $task, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->save($task);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'task/edit.html.twig',
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Task                          $task    Task entity
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
     *     name="task_delete",
     * )
     *
     * @Security(
     *     "is_granted('ROLE_ADMIN') or is_granted('DELETE', task)"
     * )
     */
    public function delete(Request $request, Task $task): Response
    {
        /*if ($task->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('task_index');
        }
        */

        $form = $this->createForm(FormType::class, $task, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->delete($task);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'task/delete.html.twig',
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );
    }
}
