<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminCategoryController extends AdminBaseController 
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/admin/category', name: 'admin_category')]
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Категории';
        $forRender['category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/category/index.html.twig', $forRender);
    } 

    /**
     * @param Request $request
     * @return RedirectResponse\Response
     */

    #[Route('/admin/category/create', name: 'admin_category_create')]
    public function create (Request $request) 
    {
        $category = new Category ();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->setCreateCategory($category);
            $this->addFlash('success', 'Категория добавлена');
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание категории';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $forRender);
    }

    #[Route('/admin/category/update/{id}', name: 'admin_category_update')]
    public function update(int $id, Request $request)
    {

        $category = $this->categoryRepository->getOneCategory($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // Следующий коммент сообщает среде о том, что get() вернет кликабельный объект, а не интерфэйс
             /** @var ClickableInterface $button  */
             $button = $form->get('save');
             if($button->isClicked()) {
                $this->categoryRepository->setUpdateCategory($category);
                $this->addFlash('success', 'Категория обновлена');
             }
           // Следующий коммент сообщает среде о том, что get() вернет кликабельный объект, а не интерфэйс
             /** @var ClickableInterface $button  */
             $button = $form->get('delete');
             if($button->isClicked()) {
                $this->categoryRepository->setDeleteCategory($category);
                $this->addFlash('success', 'Категория удалена');
             }
            return $this->redirectToRoute('admin_category');
        }
    
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование категории';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $forRender);
    }

}