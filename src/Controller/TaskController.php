<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


#[Route('/task')]
class TaskController extends AbstractController
{
    /**
     * Create a new task.
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface    $serializer
     * @param ValidatorInterface     $validator
     *
     * @return JsonResponse
     */
    #[Route('', name: 'task_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        // Get JSON data from the request
        $taskData = $request->getContent();

        try {
            // Deserialize the data into a Task object
            $task = $serializer->deserialize($taskData, Task::class, 'json');
        } catch (\Exception $e) {
            // Handle deserialization errors
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->getUser();

        if (!$user) {
            throw new NotFoundHttpException('UserDoesNotExist');
        }

        // Validate the Task object
        $errors = $validator->validate($task);
        if (count($errors) > 0) {
            // If there are validation errors, return them
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Set createdAt and other necessary fields
        $task->setCreatedAt(new \DateTimeImmutable());
        $task->setUser($user);

        // Persist the Task object in the database
        $entityManager->persist($task);
        $entityManager->flush();

        // Return a success response
        return $this->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], JsonResponse::HTTP_CREATED);
    }


    /**
     * Read a specific task by its UUID.
     *
     * @param string $id
     * @param TaskRepository $repository
     *
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'task_read', methods: ['GET'])]
    public function read(string $id, TaskRepository $repository): JsonResponse {
        // Retrieve the task by its UUID
        $task = $repository->find($id);

        // If the task is not found, return a 404 error
        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }

        // Return the task details in a JSON response
        return $this->json($task);
    }


    /**
     * Update a specific task by its UUID.
     *
     * @param string $id
     * @param Request $request
     * @param TaskRepository $repository
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'task_update', methods: ['PUT'])]
    public function update(string $id, Request $request, TaskRepository $repository, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        // Retrieve the task by its UUID
        $task = $repository->find($id);

        // If the task is not found, return a 404 error
        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }

        // Get JSON data from the request
        $taskData = $request->getContent();

        try {
            // Deserialize the data into the existing Task object
            $serializer->deserialize($taskData, Task::class, 'json', ['object_to_populate' => $task]);
        } catch (\Exception $e) {
            // Handle deserialization errors
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Validate the updated Task object
        $errors = $validator->validate($task);
        if (count($errors) > 0) {
            // If there are validation errors, return them
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Persist the updated Task object in the database
        $entityManager->flush();

        // Return a success response
        return $this->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Delete a specific task by its UUID.
     *
     * @param string $id
     * @param TaskRepository $repository
     * @param EntityManagerInterface $entityManager
     *
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'task_delete', methods: ['DELETE'])]
    public function delete(string $id, TaskRepository $repository, EntityManagerInterface $entityManager): JsonResponse {
        // Retrieve the task by its UUID
        $task = $repository->find($id);

        // If the task is not found, return a 404 error
        if (!$task) {
            throw new NotFoundHttpException('TaskDoesNotExist');
        }

        // Remove the Task from the database
        $entityManager->remove($task);
        $entityManager->flush();

        // Return a success response
        return $this->json(['message' => 'Task successfully deleted'], JsonResponse::HTTP_OK);
    }

    // List all tasks
    #[Route('', name: 'task_list', methods: ['GET'])]
    public function list(TaskRepository $repository): JsonResponse {
        // Fetch all Task objects
        // Return a JSON response with the list of Tasks
    }
}
