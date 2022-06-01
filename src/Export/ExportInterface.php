<?php

declare(strict_types=1);

namespace App\Export;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Interface ExportInterface
 * @package App\Export
 */
interface ExportInterface
{
    /**
     * @param PaginationRequestInterface $paginationRequest
     */
    public function setFilters(PaginationRequestInterface $paginationRequest): void;

    /**
     * @param Worksheet $sheet
     * @param int $row
     * @param array $legendColumns
     * @param bool $horizontal
     */
    public function writeLegend(Worksheet $sheet, int &$row, array $legendColumns = [], bool $horizontal = false): void;

    /**
     * @param Worksheet $sheet
     * @param int $row
     */
    public function writeHeader(Worksheet $sheet, int $row): void;

    /**
     * @param Worksheet $sheet
     * @param int $row
     */
    public function writeBody(Worksheet $sheet, int &$row): void;

    /**
     * @return string
     */
    public function getFileName(): string;
}