<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;

class AdminBaseController extends AbstractController
{
    public function renderDefault ()
    {
        return [
            'title' => 'Админка'
        ];
    }

    // #[Route('/admin/base', name: 'admin_base')]
    // public function index(): Response
    // {
    //     return $this->render('admin_base/index.html.twig', [
    //         'controller_name' => 'AdminBaseController',
    //     ]);
    // }
}
