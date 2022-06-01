<?php

declare(strict_types=1);

namespace App\Controller\Api\Carrier\Fedex;

use App\Model\Label\UseCase\Carrier\Fedex\Create\Command as CreateUpsCommand;
use App\Model\Label\UseCase\Carrier\Fedex\Create\Handler as CreateUpsHandler;
use App\Model\Label\UseCase\Carrier\Fedex\Update\Command as UpdateUpsCommand;
use App\Model\Label\UseCase\Carrier\Fedex\Update\Handler as UpdateUpsHandler;
use App\Model\Label\UseCase\Carrier\Fedex\Delete\Command as DeleteUpsCommand;
use App\Model\Label\UseCase\Carrier\Fedex\Delete\Handler as DeleteUpsHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/carriers/fedex", name="carrier.fedex")
 *
 * Class EditController
 *
 * @package App\Controller\Api\Carrier\Fedex
 */

class EditController extends AbstractController
{
    /**
     * @Route("/create", name=".create", methods={"POST"})
     *
     * @param CreateUpsCommand $command
     * @param CreateUpsHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function create(
        CreateUpsCommand $command,
        CreateUpsHandler $handler
    ): Response {
        $carrier = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $carrier->getId()->getValue()],
            ]
        );
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"DELETE"})
     *
     * @param DeleteUpsCommand $command
     * @param DeleteUpsHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function delete(
        DeleteUpsCommand $command,
        DeleteUpsHandler $handler
    ): Response {
        $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $command->id],
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name=".edit", methods={"POST"})
     *
     * @param UpdateUpsCommand $command
     * @param UpdateUpsHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function edit(
        UpdateUpsCommand $command,
        UpdateUpsHandler $handler
    ): Response {
        $carrier = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $carrier->getId()->getValue()],
            ]
        );
    }
}
