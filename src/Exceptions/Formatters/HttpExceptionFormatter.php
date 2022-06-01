<?php

declare(strict_types=1);


namespace App\Exceptions\Formatters;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MethodNotAllowedHttpExceptionFormatter
 * @package App\Exceptions\Formatters
 */
class HttpExceptionFormatter implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException',
        );
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if (!$exception instanceof HttpException) {
            return;
        }

        if (strpos($request->getUri(), '/api/') === 0) {
            return;
        }

        $event->setResponse(new Response($this->serializer->serialize($exception, 'json')));
    }
}