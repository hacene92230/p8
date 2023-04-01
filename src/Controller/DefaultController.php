<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/home", name="app_test")
     */
    public function index(TaskRepository $taskRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $taskRepository->createQueryBuilder('t')
            ->where('t.isDone = :isDone')
            ->setParameter('isDone', false)
            ->orderBy('t.id', 'DESC'); // ordre par défaut des résultats

        $pagination = $paginator->paginate(
            $queryBuilder, // requête à paginer
            $request->query->getInt('page', 1), // numéro de la page
            6
        );

        return $this->render('default/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
