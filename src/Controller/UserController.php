<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController.
 */
class UserController extends AbstractController
{
    /**
     * User service.
     *
     * @var \App\Service\UserService
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param \App\Service\UserService $userService User service
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Password encoder.
     *
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * User constructor.
     *
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function encoder(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/user",
     *     methods={"GET"},
     *     name="user_index",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->userService->createPaginatedList($page);

        return $this->render(
            'user/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * User action.
     *
     * @param User $userr User entity
     *
     * @Route("user/{id}", name="user_show")
     *
     * @Security(
     *     "is_granted('ROLE_ADMIN') or is_granted('EDIT', userr)"
     * )
     */
    public function show(User $userr): Response
    {
        return $this->render(
            'user/show.html.twig',
            ['user' => $userr]
        );
    }

    /**
     * Change password action.
     *
     * @param \Symfony\Component\HttpFoundation\Request                             $request         HTTP request
     * @param \App\Entity\User                                                      $userr           User entity
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder Password encoder
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "change_password/{id}",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="change_password",
     * )
     *
     * @Security(
     *     "is_granted('ROLE_ADMIN') or is_granted('EDIT', userr)"
     * )
     */
    public function changePassword(Request $request, User $userr, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(ChangePasswordType::class, $userr, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userr->setPassword(
                $passwordEncoder->encodePassword(
                    $userr,
                    $form->get('password')->getData()
                )
            );
            $this->userService->save($userr);
            $this->addFlash('success', 'message_password_changed_successfully');

            return $this->redirectToRoute('user_show', ['id' => $userr->getId()]);
        }

        return $this->render(
            'user/change_pass.html.twig',
            [
                'form' => $form->createView(),
                'user' => $userr,
            ]
        );
    }
}
