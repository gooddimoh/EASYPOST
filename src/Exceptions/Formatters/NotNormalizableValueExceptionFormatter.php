<?php

declare(strict_types=1);


namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\NotNormalizableValueExceptionHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class NotNormalizableValueExceptionFormatter implements EventSubscriberInterface
{
    private $handler;
    private $serializer;

    public function __construct(NotNormalizableValueExceptionHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException',
        );
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof NotNormalizableValueException) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new Response($this->serializer->serialize($exception, 'json')));
    }
}