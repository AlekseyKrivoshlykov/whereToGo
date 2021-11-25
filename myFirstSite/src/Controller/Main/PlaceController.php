<?php

namespace App\Controller\Main;

use App\Entity\Place;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends BaseController
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

    #[Route('/hot_springs', name: 'hot_springs')]
    public function indexHotSprings (): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Вулканы Камчатки';
        $forRender['hotSprings'] = $this->getDoctrine()->getRepository(Place::class)
                                        ->findBy(['category_place' => '2']);
        
        
        return $this->render('main/place/hotSprings/index.html.twig', $forRender);
    }
}
