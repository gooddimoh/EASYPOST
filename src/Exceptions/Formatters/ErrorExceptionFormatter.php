<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\ErrorExceptionHandler;
use ErrorException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ErrorExceptionFormatter
 * @package App\Exceptions\Formatters
 */
class ErrorExceptionFormatter implements EventSubscriberInterface
{
    private $handler;
    private $serializer;

    /**
     * ErrorExceptionFormatter constructor.
     * @param ErrorExceptionHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(ErrorExceptionHandler $handler, SerializerInterface $serializer)
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

        if (!$exception instanceof ErrorException) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new Response($this->serializer->serialize($exception, 'json')));
    }
}