<?php

declare(strict_types=1);

namespace App\Events\Listener\User\Login;

use App\Infrastructure\Flusher\FlusherInterface;
use Sinergi\BrowserDetector\Browser;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Exception;

/**
 * Class LoginListener
 * @package App\Events\Listener\User\Login
 */
class LoginListener
{
    /**
     * @var Browser
     */
    private Browser $browser;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * LoginListener constructor.
     * @param Browser $browser
     * @param FlusherInterface $flusher
     */
    public function __construct(
        Browser $browser,
        FlusherInterface $flusher
    )
    {
        $this->browser = $browser;
        $this->flusher = $flusher;
    }

    /**
     * @param InteractiveLoginEvent $event
     * @throws Exception
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {

    }
}
