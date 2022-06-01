<?php

declare(strict_types=1);

namespace App\Export\User\Legend;

use App\Export\ExportLegendInterface;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class EmptyLegend
 *
 * @package App\Export\User\Legend
 */
class EmptyLegend implements ExportLegendInterface
{
    /**
     * @param Worksheet $sheet
     * @param string    $columnLetter
     * @param int       $row
     */
    public function setData(Worksheet $sheet, string $columnLetter, int $row): void
    {
        $sheet->setCellValue($columnLetter . $row, $this->getValue());

        $sheet->getStyle($columnLetter . $row)->applyFromArray($this->getStyle());
    }

    /**
     * @return array
     */
    private function getStyle(): array
    {
        return [

        ];
    }

    /**
     * @return string
     */
    private function getValue(): string
    {
        return '';
    }
}
