<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="task_list", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $taskRepository->createQueryBuilder('t')
            ->where('t.isDone = :isDone')
            ->setParameter('isDone', true)
            ->orderBy('t.id', 'DESC'); // ordre par défaut des résultats

        $pagination = $paginator->paginate(
            $queryBuilder, // requête à paginer
            $request->query->getInt('page', 1), // numéro de la page
            6 // nombre d'éléments par page
        );

        return $this->render('task/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="task_create", methods={"GET", "POST"})
     */
    public function new(Request $request, TaskRepository $taskRepository): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $taskRepository->add($task, true);
            $this->addFlash('success', 'Tâche Correctement créer.');
            return $this->redirectToRoute('app_test', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/create.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->add($task, true);
            $this->addFlash('success', 'Tâche correctement mis à jour.');
            return $this->redirectToRoute('app_test', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="task_delete", methods={"POST", "GET"})
     */
    public function delete(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        if ($this->getUser() != $task->getUser()) {
            $this->addFlash('error', 'Impossible de supprimer une tâche que vous n\'avez pas créer.');
            return $this->redirectToRoute('app_test', [], Response::HTTP_SEE_OTHER);
        }
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
            $taskRepository->remove($task, true);
        }
        $this->addFlash('success', 'La tâche a bien été supprimée.');
        return $this->redirectToRoute('task_list', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(TaskRepository $taskRepository, Task $task)
    {
        $isDone = !$task->isDone();
        $task->toggle($isDone);
        $taskRepository->add($task, true);

        if ($isDone) {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        } else {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non faite.', $task->getTitle()));
        }

        return $this->redirectToRoute('app_test');
    }
}
