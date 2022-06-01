<?php

declare(strict_types=1);


namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\InvalidRequestDataHandler;
use App\Infrastructure\Exceptions\InvalidRequestData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class InvalidRequestDataFormatter
 * @package App\Exceptions\Formatters
 */
class InvalidRequestDataFormatter implements EventSubscriberInterface
{
    private $handler;
    private $serializer;

    public function __construct(InvalidRequestDataHandler $handler, SerializerInterface $serializer)
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
            KernelEvents::EXCEPTION => 'onKernelException',
        );
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof InvalidRequestData) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new Response($this->serializer->serialize($exception->getValidates(), 'json')));
    }
}