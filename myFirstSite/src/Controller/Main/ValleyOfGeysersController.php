<?php

namespace App\Controller\Main;

use App\Entity\Comment;
use App\Entity\Place;
use App\Entity\Image;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PlaceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValleyOfGeysersController extends BaseController
{
    #[Route('/valley_of_geysers', name: 'valley_of_geysers', methods: ['GET'])]
    public function indexValleyOfGeysers (Request $request, CommentRepository $commentRepository): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Долина Гейзеров Камчатки';
        $place = $this->getDoctrine()->getRepository(Place::class)
                                    ->findOneBy(['category_place' => '5']);
        $id = $place->getId();                           
        $images = $this->getDoctrine()->getRepository(Image::class)
                                    ->findBy(['place' => $id]);
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
                                    
            return $this->redirectToRoute('valley_of_geysers');
        }
     }
                                        
        $forRender['form'] = $form->createView();        
        return $this->render('main/place/valleyOfGeysers/index.html.twig', $forRender);
    }

}


