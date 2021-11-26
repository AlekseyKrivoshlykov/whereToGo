<?php

namespace App\Controller\Main;

use App\Entity\Place;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotSpringsController extends BaseController
{
    #[Route('/hot_springs', name: 'hot_springs')]
    public function indexHotSprings (): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Горячие источники';
        $forRender['hotSprings'] = $this->getDoctrine()->getRepository(Place::class)
                                        ->findBy(['category_place' => '2']);
        
        
        return $this->render('main/place/hotSprings/index.html.twig', $forRender);
    }

    #[Route('/hot_springs/{id}', name: 'hot_springs_id')]
    public function showOneVolcano (int $id): Response
    {
        $place = $this->getDoctrine()->getRepository(Place::class)
                                     ->find($id);
        if (!$place) {
            throw $this->createNotFoundException('Место с'. $id . 'не найдено.');
        }

        $images = $this->getDoctrine()->getRepository(Image::class)
                                      ->findBy(['place' => $id]);
        $forRender = parent::renderDefault();
        $forRender['place'] = $place;
        $forRender['images'] = $images;
        return $this->render('main/place/hotSprings/oneHotSpring.html.twig', $forRender);
    }
   
}
