<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\EntityNotFoundExceptionHandler;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class EntityNotFoundExceptionFormatter
 * @package App\Exceptions\Formatters
 */
class EntityNotFoundExceptionFormatter implements EventSubscriberInterface
{
    private $handler;
    private $serializer;

    /**
     * EntityNotFoundExceptionFormatter constructor.
     * @param EntityNotFoundExceptionHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityNotFoundExceptionHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

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
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof EntityNotFoundException) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new Response($this->serializer->serialize($exception, 'json')));
    }
}