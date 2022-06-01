<?php

declare(strict_types=1);

namespace App\Controller\Api\Transaction;

use App\Infrastructure\Services\BusinessLogicService;
use App\Model\Company\UseCase\Transaction\Credit\Command as CreditCommand;
use App\Model\Company\UseCase\Transaction\Credit\Handler as CreditHandler;

//use App\Model\Label\UseCase\AddressBook\Update\Command as UpdateCommand;
//use App\Model\Label\UseCase\AddressBook\Update\Handler as UpdateHandler;
//use App\Model\Label\UseCase\AddressBook\Delete\Command as DeleteCommand;
//use App\Model\Label\UseCase\AddressBook\Delete\Handler as DeleteHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/transactions", name="transaction")
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
     * @var BusinessLogicService
     */
    private BusinessLogicService $businessLogicService;

    /**
     * EditController constructor.
     * @param BusinessLogicService $businessLogicService
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(BusinessLogicService $businessLogicService, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->businessLogicService = $businessLogicService;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/create", name=".create", methods={"POST"})
     *
     * @param CreditCommand $command
     * @param CreditHandler $handler
     * @return Response
     * @throws \Exception
     */
    public function create(
        CreditCommand $command,
        CreditHandler $handler
    ): Response
    {
        $user = $this->businessLogicService->transactional(fn () => $handler->handle($command));

        return $this->json([
            'status' => true,
            'message' => ['id' => $user->getId()->getValue()],
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name=".edit", methods={"POST"})
//     *
//     * @param string $id
//     * @param UpdateCommand $command
//     * @param UpdateHandler $handler
//     * @return Response
//     * @throws \Exception
//     */
//    public function edit(
//        string $id,
//        UpdateCommand $command,
//        UpdateHandler $handler
//    ): Response
//    {
//        $command->id = $id;
//        $command->modifiedId = $this->getUser()->getId();
//
//        $user = $handler->handle($command);
//
//        return $this->json([
//            'status' => true,
//            'message' => ['id' => $user->getId()->getValue()],
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/delete", name=".delete", methods={"DELETE"})
//     *
//     * @param string $id
//     * @param DeleteCommand $command
//     * @param DeleteHandler $handler
//     * @return Response
//     * @throws \Exception
//     */
//    public function delete(string $id, DeleteCommand $command, DeleteHandler $handler): Response
//    {
//        $command->id = $id;
//        $command->modifiedId = $this->getUser()->getId();
//
//        $handler->handle($command);
//
//        return $this->json([
//            'status' => true,
//            'message' => ['id' => $id],
//        ]);
//    }
}
