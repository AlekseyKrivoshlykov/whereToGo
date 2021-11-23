<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostType;
use App\Services\FileManagerServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminPostController extends AdminBaseController
{
    #[Route('/admin/post', name: 'admin_post')]
    public function index(): Response
    {
        $post = $this->getDoctrine()->getRepository(Post::class)
            ->findAll();
        $checkCategory = $this->getDoctrine()->getRepository(Category::class)
            ->findAll();
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Посты';
        $forRender['post'] = $post;
        $forRender['check_category'] = $checkCategory;
        return $this->render('admin/post/index.html.twig', $forRender);
    } 

    #[Route('/admin/post/create', name: 'admin_post_create')]
    public function create (Request $request, FileManagerServiceInterface $fileManagerService) 
    {
        $em = $this->getDoctrine()->getManager();
        $post = new Post ();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if($image) {
                $fileName = $fileManagerService->imagePostUpload($image);
                $post->setImage($fileName);
            }
            $post->setCreateAtValue();
            $post->setUpdateAtValue();
            $post->setIsPublished();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Пост добавлен');
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание поста';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }

    #[Route('/admin/post/update/{id}', name: 'admin_post_update')]
    public function update ($id, Request $request, FileManagerServiceInterface $fileManagerService) 
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository(Post::class)
            ->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Следующий коммент сообщает среде о том, что get() вернет кликабельный объект, а не интерфэйс
             /** @var ClickableInterface $button  */
                $button = $form->get('save');
                if($button->isClicked()) {
                $image = $form->get('image')->getData();
                $imageOld = $post->getImage();
                if($image) {
                    if($imageOld) {
                        $fileManagerService->removePostImage($imageOld);
                    }
                    $fileName = $fileManagerService->imagePostUpload($image);
                    $post->setImage($fileName);
                }
                $post->setUpdateAtValue();
                $this->addFlash('success', 'Пост обновлён');
            } 
            // Следующий коммент сообщает среде о том, что get() вернет кликабельный объект, а не интерфэйс
            /** @var ClickableInterface $button  */
                $button = $form->get('delete');
                if($button->isClicked()){
                $image = $post->getImage();
                if($image){
                    $fileManagerService->removePostImage($image);
                }
                $em->remove($post);
                $this->addFlash('success', 'Пост удалён');
            }

            $em->flush();
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование поста';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }
}
