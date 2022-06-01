<?php

declare(strict_types=1);

namespace App\ReadModels\News;

class NewsFilter
{
    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var array|null
     */
    public ?array $status = null;

    /**
     * @var string|null
     */
    public ?string $date = null;
}
