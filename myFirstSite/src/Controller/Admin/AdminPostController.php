<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use App\Services\FileManagerServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminPostController extends AdminBaseController
{
    private $categoryRepository;
    private $postRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, PostRepositoryInterface $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    #[Route('/admin/post', name: 'admin_post')]
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Посты';
        $forRender['post'] = $this->postRepository->getAllPost();
        $forRender['check_category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/post/index.html.twig', $forRender);
    } 

    #[Route('/admin/post/create', name: 'admin_post_create')]
    public function create (Request $request) 
    {
        $post = new Post ();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $this->postRepository->setCreatePost($post, $file);
            $this->addFlash('success', 'Пост добавлен');
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание поста';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }

    #[Route('/admin/post/update/{id}', name: 'admin_post_update')]
    public function update ($id, Request $request) 
    {
        $post = $this->postRepository->getOnePost($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Следующий коммент сообщает среде о том, что get() вернет кликабельный объект, а не интерфэйс
             /** @var ClickableInterface $button  */
                $button = $form->get('save');
                if($button->isClicked()) {
                $file = $form->get('image')->getData();
                $this->postRepository->setUpdatePost($post, $file);
                $this->addFlash('success', 'Пост обновлён');
            } 
            // Следующий коммент сообщает среде о том, что get() вернет кликабельный объект, а не интерфэйс
            /** @var ClickableInterface $button  */
                $button = $form->get('delete');
                if($button->isClicked()){
                $this->postRepository->setDeletePost($post);
                $this->addFlash('success', 'Пост удалён');
            }
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование поста';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }
}
