<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController {

    public function renderDefault () {
        return [
            'title' => 'Добро пожаловать на сайт Kamplaces!'
        ];
    }
}