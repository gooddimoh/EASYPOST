<?php

declare(strict_types=1);

namespace App\Export\Transaction;

use App\Export\Transaction\Legend\BlueLineLegend;
use App\Export\Transaction\Legend\DescriptionLegend;
use App\Export\Transaction\Legend\EmptyLegend;
use App\Export\Transaction\Legend\LogoLegend;
use App\Export\ExportInterface;
use App\Export\ExportLegendInterface;
use App\Infrastructure\Enums\Model\Transaction\StatusEnum;
use App\Infrastructure\Enums\Model\Transaction\TypeEnum;
use App\Infrastructure\IteratorRequest\IteratorRequest;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\ReadModels\Transaction\TransactionFetcher;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class ConsultationExport
 *
 * @package App\Export\Transaction
 */
class TransactionExport implements ExportInterface
{
    /**
     * @var string
     */
    private const FILE_NAME = 'Transaction list';

    /**
     * @var TransactionFetcher
     */
    private TransactionFetcher $transactionFetcher;

    /**
     * @var IteratorRequest
     */
    private IteratorRequest $iteratorRequest;

    /**
     * @var PaginationRequestInterface
     */
    private PaginationRequestInterface $paginationRequest;

    /**
     * @var string
     */
    private string $fileName;

    /**
     * CompanyExport constructor.
     *
     * @param TransactionFetcher $transactionFetcher
     * @param IteratorRequest    $iteratorRequest
     */
    public function __construct(TransactionFetcher $transactionFetcher, IteratorRequest $iteratorRequest)
    {
        $this->transactionFetcher = $transactionFetcher;
        $this->iteratorRequest = $iteratorRequest;
        $this->fileName = self::FILE_NAME;
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
     * @param array     $legendColumns
     * @param bool      $horizontal
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
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
     * @param Worksheet $sheet
     * @param int       $row
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
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
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
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
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
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
        ?string   $coordinate,
        ?string   $data,
        string    $column,
        array     $styles
    ): void {
        $sheet->getStyle($coordinate)->applyFromArray($styles);

        switch ($column) {
            case 'type':
                $sheet->setCellValue($coordinate, TypeEnum::DEBIT == $data ? 'DEBIT' : 'CREDIT');
                break;

            case 'email':
                $sheet->getHyperlink($coordinate)->setUrl("mailto:{$data}");
                break;

            case 'balance':
                $sheet->setCellValue($coordinate, $data / 100);
                break;

            case 'status':
                $sheet->setCellValue($coordinate, $this->statusToString((int) $data));
                break;

            default:
                $sheet->setCellValue($coordinate, $data);
                break;
        }
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
    private function getHeader(): array
    {
        return [
            'date' => 'Date',
            'type' => 'Type',
            'balance' => 'Balance',
            'carrier' => 'Carrier',
            'description' => 'Description',
            'user_name' => 'User name',
            'status' => 'Status',
        ];
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    private function getBody()
    {
        $query = $this->transactionFetcher->getQuery($this->paginationRequest, [
            't.date AS date',
            't.type_value::text AS type',
            't.balance_value::text as balance',
            't.type_options::json->>\'carrier\' AS carrier',
            't.description_value as description',
            'u.name_value AS user_name',
            't.status_value::text AS status',
        ]);

        $this->iteratorRequest->setQuery($query);
        $this->iteratorRequest->setLimit(100);

        return $this->iteratorRequest;
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
     * @param int $status
     *
     * @return string
     */
    private function statusToString(int $status): string
    {
        $response = '';

        switch ($status) {
            case StatusEnum::FAIL:
                $response = 'FAIL';
                break;
            case StatusEnum::PENDING:
                $response = 'PENDING';
                break;
            case StatusEnum::SUCCESS:
                $response = 'SUCCESS';
                break;
        }

        return $response;
    }
}
