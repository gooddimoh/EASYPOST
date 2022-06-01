<?php

declare(strict_types=1);

namespace App\Export\Transaction\Legend;

use App\Export\ExportLegendInterface;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class DescriptionLegend
 * @package App\Export\Company\Legend
 */
class DescriptionLegend implements ExportLegendInterface
{
    /**
     * @var int
     */
    const MERGE_COLUMNS = 1;

    /**
     * @param Worksheet $sheet
     * @param string $columnLetter
     * @param int $row
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function setData(Worksheet $sheet, string $columnLetter, int $row): void
    {
        $sheet->setCellValue($columnLetter . $row, $this->getValue());

        $sheet->getStyle($columnLetter . $row)->applyFromArray($this->getStyle());
        $sheet->mergeCells($this->getMerge($columnLetter, $row));
    }

    /**
     * @return string
     */
    private function getValue(): string
    {
        return 'Sell more, collaborate, and improve visibility & forecasting with the leading sales, service and information management cloud application built for any level of the supply chain.';
    }

    /**
     * @return array
     */
    private function getStyle(): array
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
                'indent' => 1,
            ],
            'font' => [
                'name' => 'Arial',
                'size' => 9,
            ]
        ];
    }

    /**
     * @param string $columnLetter
     * @param int $row
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
}
