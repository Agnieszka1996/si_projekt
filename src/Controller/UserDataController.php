<?php
/**
 * UserData controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserData;
use App\Form\UserDataType;
use App\Repository\UserDataRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserDataController.
 *
 * @Route("/user-data")
 *
 * @IsGranted("ROLE_USER")
 */
class UserDataController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Entity\UserData $userdata UserData entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="user-data_index",
     * )
     */
    public function index(): Response
    {

        return $this->render(
            'userdata/index.html.twig'
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\UserData $userdata UserData entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="user-data_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(UserData $userdata): Response
    {
        $userdata->setUser($this->getUser());
        return $this->render(
            'userdata/show.html.twig',
            ['userdata' => $userdata]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\UserData                      $userdata           UserData entity
     * @param \App\Repository\UserDataRepository        $userdataRepository UserData repository
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
     *     name="user-data_edit",
     * )
     */
    public function edit(Request $request, UserData $userdata, UserDataRepository $userdataRepository): Response
    {
        $form = $this->createForm(UserDataType::class, $userdata, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userdataRepository->save($userdata);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'userdata/edit.html.twig',
            [
                'form' => $form->createView(),
                'userdata' => $userdata,
            ]
        );
    }
}