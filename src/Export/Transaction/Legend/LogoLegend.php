<?php

declare(strict_types=1);

namespace App\Export\Transaction\Legend;

use App\Export\ExportLegendInterface;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class LogoLegend
 * @package App\Export\Company\Legend
 */
class LogoLegend implements ExportLegendInterface
{
    /**
     * @var int
     */
    const HEIGHT = 20;

    /**
     * @var string
     */
    const NAME = 'Comopps';

    /**
     * @var string
     */
    const DESCRIPTION = 'Comopps enterprise';

    /**
     * @var string
     */
    const PATH = 'img/export_logo.png';

    /**
     * @param Worksheet $sheet
     * @param string $columnLetter
     * @param int $row
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function setData(Worksheet $sheet, string $columnLetter, int $row): void
    {
        $drawing = $this->getValue($columnLetter, $row);
        $drawing->setWorksheet($sheet);

        $sheet->getStyle($columnLetter . $row)->applyFromArray($this->getStyle());
        $sheet->getRowDimension($row)->setRowHeight(40);
    }

    /**
     * @param string $columnLetter
     * @param int $row
     * @return Drawing
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function getValue(string $columnLetter, int $row): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName(self::NAME);
        $drawing->setDescription(self::DESCRIPTION);
        $drawing->setPath(self::PATH);
        $drawing->setOffsetX(90);
        $drawing->setOffsetY(15);
        $drawing->setCoordinates($columnLetter . $row);
        $drawing->setHeight(self::HEIGHT);

        return $drawing;
    }

    /**
     * @return array
     */
    private function getStyle(): array
    {
        return [

        ];
    }
}
