<?php

namespace App\Controller\SearchController;

use App\Entity\Place;
use App\Entity\Image;
use App\Controller\Main\BaseController;
use App\Repository\CategoryPlaceRepository;
use App\Repository\CategoryPlaceRepositoryInterface;
use App\Repository\PlaceRepository;
use App\Repository\PlaceRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends BaseController
{
    private $placeRepository;
    private $categoryRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository, CategoryPlaceRepositoryInterface $categoryRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/search', name: 'search')]
    public function searchIndex (Request $request): Response
    {
        $query = $request->query->get('q');
        $searchResult = $this->placeRepository->findQuery($query);
        $forRender['title'] = 'Результаты поиска';
   
        if(empty($query) or empty($searchResult)) {
            $this->addFlash('danger', 'Место не найдено');
            return $this->render('search/badSearch.html.twig', $forRender);
        } else {
            $forRender = parent::renderDefault();
            $forRender['places'] = $searchResult;
            $categoryPlaceId = [];
            $nameCategory = [];
            foreach($searchResult as $value) {
                $categoryPlaceId = $value['1'];
                $nameCategory = $this->categoryRepository->findCategory($categoryPlaceId);
            }
     
            $forRender['nameCategory'] = $nameCategory;  
            return $this->render('search/index.html.twig', $forRender);
        }  
    }
}
