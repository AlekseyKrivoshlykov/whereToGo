<?php

namespace App\Controller\Main;

use App\Entity\Place;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VolcanoController extends BaseController
{
    #[Route('/volcanoes', name: 'volcanoes')]
    public function indexVolcanoes (): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Вулканы Камчатки';
        $forRender['volcanoes'] = $this->getDoctrine()->getRepository(Place::class)
                                        ->findBy(['category_place' => '1']);
        
        return $this->render('main/place/volcanoes/index.html.twig', $forRender);
    }

    #[Route('/volcanoes/{id}', name: 'volcanoes_id')]
    public function showOneVolcano (int $id): Response
    {
        $place = $this->getDoctrine()->getRepository(Place::class)
                                    ->find($id);
        if (!$place) {
            throw $this->createNotFoundException('Место с'. $id . 'не найдено.');
        }
        $forRender = parent::renderDefault();
        $forRender['place'] = $place;
    
        return $this->render('main/place/volcanoes/oneVolcano.html.twig', $forRender);
    }
   
}
