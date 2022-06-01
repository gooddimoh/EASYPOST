<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Information
 *
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Information
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $service;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $carrier;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $track;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $labelUrl;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $trackUrl;

    /**
     * Information constructor.
     *
     * @param string|null $service
     * @param string|null $carrier
     * @param string|null $track
     * @param string|null $labelUrl
     * @param string|null $trackUrl
     */
    public function __construct(
        ?string $service = null,
        ?string $carrier = null,
        ?string $track = null,
        ?string $labelUrl = null,
        ?string $trackUrl = null
    ) {
        $this->service = $service;
        $this->carrier = $carrier;
        $this->track = $track;
        $this->labelUrl = $labelUrl;
        $this->trackUrl = $trackUrl;
    }

    /**
     * @param self $info
     *
     * @return bool
     */
    public function isEqual(self $info): bool
    {
        return $this->service === $info->getService() &&
            $this->carrier === $info->getCarrier() &&
            $this->track === $info->getTrack();
    }

    /**
     * @return string|null
     */
    public function getService(): ?string
    {
        return $this->service;
    }

    /**
     * @return string|null
     */
    public function getCarrier(): ?string
    {
        return $this->carrier;
    }

    /**
     * @return string|null
     */
    public function getTrack(): ?string
    {
        return $this->track;
    }

    /**
     * @return string|null
     */
    public function getLabelUrl(): ?string
    {
        return $this->labelUrl;
    }

    /**
     * @return string|null
     */
    public function getTrackUrl(): ?string
    {
        return $this->trackUrl;
    }
}
