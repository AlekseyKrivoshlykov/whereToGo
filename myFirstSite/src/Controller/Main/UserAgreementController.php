<?php

namespace App\Controller\Main;

use Symfony\Component\Routing\Annotation\Route;


class UserAgreementController extends BaseController {
   
    #[Route('/user_agreement', name: 'user_agreement')]
     
    public function index () {

        $forRender = parent::renderDefault();
        return $this->render('documents/userAgreement.html.twig', $forRender);
    }

}

?>