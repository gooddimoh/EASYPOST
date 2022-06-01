<?php

declare(strict_types=1);


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class KeyNumberFilter extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_quantity_months', [$this, 'format']),
        ];
    }

    public function format(array $items): array
    {
        $res = [];

        foreach ($items as $item) {
            $res[$item->year] = [
                'January'=> "{$item->jan}",
                'February'=> "{$item->feb}",
                'March'=> "{$item->mar}",
                'April'=> "{$item->apr}",
                'May'=> "{$item->may}",
                'June'=> "{$item->jun}",
                'July'=> "{$item->jul}",
                'August'=> "{$item->aug}",
                'September'=> "{$item->sep}",
                'October'=> "{$item->oct}",
                'November'=> "{$item->nov}",
                'December'=> "{$item->dec}"
            ];
        }

        return $res;
    }
}