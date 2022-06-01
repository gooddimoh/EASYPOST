<?php

declare(strict_types=1);

namespace App\Export;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Interface ExportLegendInterface
 * @package App\Export
 */
interface ExportLegendInterface
{
    /**
     * @param Worksheet $sheet
     * @param string $columnLetter
     * @param int $row
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function setData(Worksheet $sheet, string $columnLetter, int $row): void;
}