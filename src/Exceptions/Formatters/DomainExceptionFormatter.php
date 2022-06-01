<?php

declare(strict_types=1);


namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\DomainErrorHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class DomainExceptionFormatter implements EventSubscriberInterface
{
    private $handler;
    private $serializer;

    public function __construct(DomainErrorHandler $handler, SerializerInterface $serializer)
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
        $request = $event->getRequest();

        if (!$exception instanceof \DomainException) {
            return;
        }

        if (strpos($request->attributes->get('_route'), 'api.') !== 0) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new Response($this->serializer->serialize($exception, 'json')));
    }
}
