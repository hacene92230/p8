<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'tasks' => $taskRepository->findBy(["isDone" => false]),
        ]);
    }
}
