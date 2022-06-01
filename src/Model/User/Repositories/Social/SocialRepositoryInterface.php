<?php

declare(strict_types=1);

namespace App\Model\User\Repositories\Social;

use App\Model\User\Entity\Social\Fields\SocialId;
use App\Model\User\Entity\Social\Fields\Type;
use App\Model\User\Entity\Social\Social;

interface SocialRepositoryInterface
{
    /**
     * @param SocialId $socialId
     * @param Type     $type
     *
     * @return Social
     */
    public function get(SocialId $socialId, Type $type): Social;

    /**
     * @param Social $social
     */
    public function add(Social $social): void;

    /**
     * @param string $userId
     */
    public function delete(string $userId): void;
}
