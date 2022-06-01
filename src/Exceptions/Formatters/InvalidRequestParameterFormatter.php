<?php

declare(strict_types=1);


namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\InvalidRequestParameterHandler;
use App\Infrastructure\Exceptions\InvalidRequestParameter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class InvalidRequestDataFormatter
 * @package App\Exceptions\Formatters
 */
class InvalidRequestParameterFormatter implements EventSubscriberInterface
{
    private $handler;
    private $serializer;

    public function __construct(InvalidRequestParameterHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof InvalidRequestParameter) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new Response($this->serializer->serialize($exception, 'json')));
    }
}