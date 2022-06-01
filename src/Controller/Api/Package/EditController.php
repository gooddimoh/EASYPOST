<?php

declare(strict_types=1);

namespace App\Controller\Api\Package;

use App\Model\Company\UseCase\Package\Create\Command as CreateCommand;
use App\Model\Company\UseCase\Package\Create\Handler as CreateHandler;
use App\Model\Company\UseCase\Package\Update\Command as UpdateCommand;
use App\Model\Company\UseCase\Package\Update\Handler as UpdateHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/packages", name="package")
 *
 * Class EditController
 *
 * @package App\Controller\Api\Package
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
     *
     * @param SerializerInterface $serializer
     * @param ValidatorInterface  $validator
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
     *
     * @return Response
     * @throws \Exception
     */
    public function create(
        CreateCommand $command,
        CreateHandler $handler
    ): Response {
        $package = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $package->getId()->getValue()],
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name=".edit", methods={"POST"})
     *
     * @param UpdateCommand $command
     * @param UpdateHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function edit(
        UpdateCommand $command,
        UpdateHandler $handler
    ): Response {
        $package = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $package->getId()->getValue()],
            ]
        );
    }
}
