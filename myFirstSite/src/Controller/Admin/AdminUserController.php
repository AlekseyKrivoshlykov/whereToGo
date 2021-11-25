<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use App\Services\User\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminUserController extends AdminBaseController
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    #[Route('/admin/user', name: 'admin_user')]
    public function index () : Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Пользователи';
        $forRender['users'] = $this->userRepository->getAll();
        return $this->render('admin/user/index.html.twig', $forRender);

    }

    /**
     * @param Request $request
     * @return RedirectResponse\Response
     */

    #[Route('/admin/user/create', name: 'admin_user_create')]
    public function createAction (Request $request)
    // public function create (Request $request, UserPasswordHasherInterface $passwordEncoder)
       
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $this->userService->handleCreate($user);
            return $this->redirectToRoute('admin_user');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Форма создания пользователя на сайте';
        $forRender['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig', $forRender);

    }
}