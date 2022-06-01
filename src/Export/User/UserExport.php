<?php

declare(strict_types=1);

namespace App\Export\User;

use App\Export\ExportInterface;
use App\Export\ExportLegendInterface;
use App\Infrastructure\IteratorRequest\IteratorRequest;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\ReadModels\User\UserFetcher;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class UserExport
 *
 * @package App\Export\User
 */
class UserExport implements ExportInterface
{
    /**
     * @var string
     */
    private const FILE_NAME = 'User data';

    /**
     * @var string
     */
    private string $fileName;

    /**
     * @var IteratorRequest
     */
    private IteratorRequest $iteratorRequest;

    /**
     * @var PaginationRequestInterface
     */
    private PaginationRequestInterface $paginationRequest;

    /**
     * @var UserFetcher
     */
    private UserFetcher $userFetcher;

    /**
     * UserExport constructor.
     *
     * @param UserFetcher     $userFetcher
     * @param IteratorRequest $iteratorRequest
     */
    public function __construct(UserFetcher $userFetcher, IteratorRequest $iteratorRequest)
    {
        $this->userFetcher = $userFetcher;
        $this->iteratorRequest = $iteratorRequest;
        $this->fileName = self::FILE_NAME;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     */
    public function setFilters(PaginationRequestInterface $paginationRequest): void
    {
        $this->paginationRequest = $paginationRequest;
    }

    /**
     * @param Worksheet $sheet
     * @param int       $row
     *
     * @throws ExceptionInterface
     */
    public function writeBody(Worksheet $sheet, int &$row): void
    {
        $data = $this->getBody();
        $headerColumns = $this->getHeader();
        $tableStyle = $this->getTableColumnsStyle();

        while (($items = $data->next()) !== false) {
            foreach ($items as $item) {
                $columnLetter = 'A';
                $row++;

                foreach ($headerColumns as $column => $columnLabel) {
                    $coordinate = $columnLetter . $row;
                    $this->writeOnceBodyColumn(
                        $sheet,
                        $coordinate,
                        $item[$column],
                        $column,
                        $tableStyle[$column] ?? []
                    );

                    $columnLetter++;
                }
            }
        }
    }

    /**
     * @param Worksheet $sheet
     * @param int       $row
     */
    public function writeHeader(Worksheet $sheet, int $row): void
    {
        $columnLetter = 'A';
        $headerColumns = $this->getHeader();

        foreach ($headerColumns as $columnLabel) {
            $coordinate = $columnLetter . $row;

            $sheet->setCellValue($coordinate, $columnLabel);
            $sheet->getStyle($coordinate)->applyFromArray($this->getHeaderColumnsStyle());

            $columnLetter++;
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        }
    }

    /**
     * @param Worksheet $sheet
     * @param int       $row
     * @param array     $legendColumns
     * @param bool      $horizontal
     *
     * @throws Exception
     */
    public function writeLegend(Worksheet $sheet, int &$row, array $legendColumns = [], bool $horizontal = false): void
    {
        $columnLetter = 'A';
        $legendColumns = $legendColumns ?: $this->getLegend();

        foreach ($legendColumns as $value) {
            if (is_array($value)) {
                $this->writeLegend($sheet, $row, $value, true);
            } else {
                /**
                 * @var ExportLegendInterface $column
                 */
                $column = new $value();
                $column->setData($sheet, $columnLetter, $row);
            }

            $horizontal ? $columnLetter++ : $row++;
        }
    }

    /**
     * @return IteratorRequest
     * @throws ExceptionInterface
     */
    private function getBody(): IteratorRequest
    {
        $query = $this->userFetcher->getQuery(
            $this->paginationRequest,
            [
                't.date AS date',
                'TRIM(t.name_value) AS full_name',
                'c.name_value AS company_name',
                't.email_value AS email',
                'TRIM(CONCAT(t.phone_code, t.phone_number)) AS phone',
                't.role_value AS role'
            ]
        );

        $this->iteratorRequest->setQuery($query);
        $this->iteratorRequest->setLimit(100);

        return $this->iteratorRequest;
    }

    /**
     * @return array
     */
    private function getHeader(): array
    {
        return [
            'date' => 'Register date',
            'full_name' => 'Full name',
            'company_name' => 'Company',
            'email' => 'Email',
            'phone' => 'Phone',
            'role' => 'Role',
        ];
    }

    /**
     * @return array
     */
    private function getHeaderColumnsStyle(): array
    {
        return [
            'font' => [
                'name' => 'Calibri',
                'size' => 12,
                'bold' => true
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'E0E0E0',
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function getLegend(): array
    {
        return [
//            EmptyLegend::class,
//            [
//                LogoLegend::class,
//                DescriptionLegend::class,
//            ],
//            BlueLineLegend::class
        ];
    }

    /**
     * @return array
     */
    private function getTableColumnsStyle(): array
    {
        return [
            'user_name' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'wrapText' => true,
                ]
            ],
        ];
    }

    /**
     * @param Worksheet   $sheet
     * @param string|null $coordinate
     * @param string|null $data
     * @param string      $column
     * @param array       $styles
     */
    private function writeOnceBodyColumn(
        Worksheet $sheet,
        ?string $coordinate,
        ?string $data,
        string $column,
        array $styles
    ): void {
        $sheet->getStyle($coordinate)->applyFromArray($styles);

        switch ($column) {
            default:
                $sheet->setCellValue($coordinate, $data);
                break;
        }
    }
}
