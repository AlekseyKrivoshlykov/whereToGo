<?php

namespace App\Controller\Main;

use App\Entity\Comment;
use App\Entity\Place;
use App\Entity\Image;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LakesController extends BaseController
{
    #[Route('/lakes', name: 'lakes')]
    public function indexLakes (): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Озёра Камчатки';
        $forRender['lakes'] = $this->getDoctrine()->getRepository(Place::class)
                                        ->findBy(['category_place' => '4']);
        
        
        return $this->render('main/place/lakes/index.html.twig', $forRender);
    }

    #[Route('/lakes/{id}', name: 'lakes_id')]
    public function showOneHotSpring (int $id, Request $request, CommentRepository $commentRepository, Place $place): Response
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
        
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($place, $offset);
        $forRender['comments'] = $paginator;
        $forRender['previous'] = $offset - CommentRepository::PAGINATOR_PER_PAGE;
        $forRender['next'] = min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE);

        $newComment = new Comment();
        $form = $this->createForm(CommentType::class, $newComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        /** @var ClickableInterface $button  */
        $button = $form->get('submit');
            if($button->isClicked() && !$this->get('security.authorization_checker')
                                        ->isGranted('IS_AUTHENTICATED_FULLY')) {   
            $this->addFlash('danger', 'Только авторизованные посетители могут оставлять комментарии.');
        } else {
        $newComment->setUser($this->getUser());
        $place->addComment($newComment);
        $newComment->setIsPublished();
        $em = $this->getDoctrine()->getManager();
        $em->persist($newComment);
        $em->flush();

        return $this->redirectToRoute('lakes_id', ['id' => $id]);
              }
        }
    
        $forRender['form'] = $form->createView();
        return $this->render('main/place/lakes/oneLake.html.twig', $forRender);    
    }
}
