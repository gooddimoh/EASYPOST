<?php

declare(strict_types=1);

namespace App\Model\News\Repositories\News;

use App\Model\News\Entity\News\Fields\Id;
use App\Model\News\Entity\News\News;

interface NewsRepositoryInterface
{
    /**
     * @param Id $id
     *
     * @return News
     */
    public function get(Id $id): News;

    /**
     * @param News $news
     */
    public function add(News $news): void;
}
