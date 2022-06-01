<?php

declare(strict_types=1);

namespace App\Export\User\Legend;

use App\Export\ExportLegendInterface;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class BlueLineLegend
 *
 * @package App\Export\User\Legend
 */
class BlueLineLegend implements ExportLegendInterface
{
    /**
     * @var int
     */
    const MERGE_COLUMNS = 13;

    /**
     * @param Worksheet $sheet
     * @param string    $columnLetter
     * @param int       $row
     *
     * @throws Exception
     */
    public function setData(Worksheet $sheet, string $columnLetter, int $row): void
    {
        $sheet->setCellValue($columnLetter . $row, $this->getValue());

        $sheet->getStyle($columnLetter . $row)->applyFromArray($this->getStyle());
        $sheet->mergeCells($this->getMerge($columnLetter, $row));
    }

    /**
     * @param string $columnLetter
     * @param int    $row
     *
     * @return string
     */
    private function getMerge(string $columnLetter, int $row): string
    {
        $alphas = range('A', 'Z');
        $currentLetterIndex = array_search($columnLetter, $alphas);

        $start = $columnLetter . $row;
        $end = $alphas[$currentLetterIndex + self::MERGE_COLUMNS] . $row;

        return "{$start}:{$end}";
    }

    /**
     * @return array
     */
    private function getStyle(): array
    {
        return [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'CCE5FF',
                ]
            ]
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
