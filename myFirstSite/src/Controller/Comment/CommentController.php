<?php

namespace App\Controller\Comment;

use App\Entity\Comment;
use App\Form\Comment1Type;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

use function PHPUnit\Framework\throwException;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        // dd($request);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $previousUrl = $request->headers->get('referer');
        $encodeUrl = base64_encode($previousUrl);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $urlFromForm = $request->request->get('url');
            $decodeUrl = base64_decode($urlFromForm);
            $currentHost = parse_url($decodeUrl, PHP_URL_HOST);
            if($currentHost == 'kamplaces') {
                return $this->redirect($decodeUrl); 
            } else {
                throw new Exception();
            }
        }

        return $this->renderForm('comment/_edit_form.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'encodeUrl' => $encodeUrl,
        ]);
    }

    #[Route('/{id}', name: 'comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager)
    {   
        $referer = $request->headers->get('referer');

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirect($referer);
    }
}
