<?php

declare(strict_types=1);


namespace App\Renderer;

use Limenius\ReactRenderer\Renderer\PhpExecJsReactRenderer;
use Symfony\Component\Asset\Packages;

class CustomReactRenderer extends PhpExecJsReactRenderer
{
    /**
     * @param Packages $packages
     * @param string   $serverBundlePath
     */
    public function setPackage(Packages $packages, string $serverBundlePath)
    {
        $this->serverBundlePath .= $packages->getUrl($serverBundlePath);
    }
}
