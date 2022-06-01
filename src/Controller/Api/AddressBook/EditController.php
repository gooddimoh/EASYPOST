<?php

declare(strict_types=1);

namespace App\Controller\Api\AddressBook;

use App\Model\Label\UseCase\AddressBook\Create\Command as CreateCommand;
use App\Model\Label\UseCase\AddressBook\Create\Handler as CreateHandler;
use App\Model\Label\UseCase\AddressBook\Update\Command as UpdateCommand;
use App\Model\Label\UseCase\AddressBook\Update\Handler as UpdateHandler;
use App\Model\Label\UseCase\AddressBook\Delete\Command as DeleteCommand;
use App\Model\Label\UseCase\AddressBook\Delete\Handler as DeleteHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/address-books", name="address-book")
 *
 * Class EditController
 * @package App\Controller\Api\User
 */
class EditController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * EditController constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/create", name=".create", methods={"POST"})
     *
     * @param CreateCommand $command
     * @param CreateHandler $handler
     * @return Response
     * @throws \Exception
     */
    public function create(
        CreateCommand $command,
        CreateHandler $handler
    ): Response
    {
        $user = $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => ['id' => $user->getId()->getValue()],
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit", methods={"POST"})
     *
     * @param string $id
     * @param UpdateCommand $command
     * @param UpdateHandler $handler
     * @return Response
     * @throws \Exception
     */
    public function edit(
        string $id,
        UpdateCommand $command,
        UpdateHandler $handler
    ): Response
    {
        $user = $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => ['id' => $id],
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"DELETE"})
     *
     * @param string $id
     * @param DeleteCommand $command
     * @param DeleteHandler $handler
     * @return Response
     * @throws \Exception
     */
    public function delete(string $id, DeleteCommand $command, DeleteHandler $handler): Response
    {
        $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => ['id' => $id],
        ]);
    }
}
