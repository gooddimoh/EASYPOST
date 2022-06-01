<?php


namespace App\Events\Listener\Kernel;

use App\Infrastructure\Flusher\FlusherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ResponseSubscriber
 * @package App\Events\Listener\Kernel
 */
class ResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * ResponseSubscriber constructor.
     * @param FlusherInterface $flusher
     */
    public function __construct(FlusherInterface $flusher)
    {
        $this->flusher = $flusher;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE => 'onKernelResponse',
        ];
    }

    /**
     * @param TerminateEvent $event
     */
    public function onKernelResponse(TerminateEvent $event): void
    {
        $responseStatus = $event->getResponse()->isSuccessful() || $event->getResponse()->isRedirection();

        if ($responseStatus && !$event->getRequest()->isMethod('GET')) {
            $this->flusher->dispatchEvents();
        }
    }
}
