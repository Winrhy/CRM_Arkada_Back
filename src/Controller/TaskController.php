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

   /* // Read a specific task by ID
    #[Route('/{id}', name: 'task_read', methods: ['GET'])]
    public function read(Task $task): JsonResponse {
        // Return a JSON response with the Task details
    }

    // Update a specific task by ID
    #[Route('/{id}', name: 'task_update', methods: ['PUT'])]
    public function update(Request $request, Task $task, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        // Deserialize the JSON request into the existing Task object
        // Validate the updated Task object
        // Update the Task object in the database
        // Return a JSON response
    }

    // Delete a specific task by ID
    #[Route('/{id}', name: 'task_delete', methods: ['DELETE'])]
    public function delete(Task $task, EntityManagerInterface $entityManager): JsonResponse {
        // Remove the Task from the database
        // Return a JSON response
    }*/

    // List all tasks
    #[Route('', name: 'task_list', methods: ['GET'])]
    public function list(TaskRepository $repository): JsonResponse {
        // Fetch all Task objects
        // Return a JSON response with the list of Tasks
    }
}
