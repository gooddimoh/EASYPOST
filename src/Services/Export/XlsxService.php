<?php

declare(strict_types=1);

namespace App\Services\Export;

use App\Export\ExportInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class XlsxService
 * @package App\Services\Export
 */
class XlsxService
{
    /**
     * @var Spreadsheet
     */
    private Spreadsheet $spreadsheet;

    /**
     * XlsxService constructor.
     * @param Spreadsheet $spreadsheet
     */
    public function __construct(Spreadsheet $spreadsheet)
    {
        $this->spreadsheet = $spreadsheet;
    }

    /**
     * @param ExportInterface $export
     * @return XlsxResponseService
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function generate(ExportInterface $export): XlsxResponseService
    {
        $row = 1;
        $sheet = $this->spreadsheet->getActiveSheet();
        $sheet->setTitle($export->getFileName());
        $sheet->getColumnDimension('A')->setWidth(40);

        $export->writeLegend($sheet, $row);
        $export->writeHeader($sheet, $row);
        $export->writeBody($sheet, $row);

        $writer = new Xlsx($this->spreadsheet);

        $fileName = $export->getFileName() . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);

        $writer->save($tempFile);

        return XlsxResponseService::instance($tempFile, $fileName);
    }
}
