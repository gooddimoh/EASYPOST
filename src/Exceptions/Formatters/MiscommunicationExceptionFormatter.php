<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\MiscommunicationExceptionHandler;
use App\Infrastructure\Exceptions\MiscommunicationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MiscommunicationExceptionFormatter
 *
 * @package App\Exceptions\Formatters
 */
class MiscommunicationExceptionFormatter implements EventSubscriberInterface
{
    /**
     * @var MiscommunicationExceptionHandler
     */
    private MiscommunicationExceptionHandler $handler;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * MiscommunicationExceptionFormatter constructor.
     *
     * @param MiscommunicationExceptionHandler $handler
     * @param SerializerInterface              $serializer
     */
    public function __construct(MiscommunicationExceptionHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof MiscommunicationException) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new Response($this->serializer->serialize($exception, 'json')));
    }
}