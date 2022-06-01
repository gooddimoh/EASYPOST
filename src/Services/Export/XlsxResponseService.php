<?php

declare(strict_types=1);

namespace App\Services\Export;

/**
 * Class XlsxResponseService
 * @package App\Services\Export
 */
class XlsxResponseService
{
    /**
     * @var string
     */
    private string $tempFile;

    /**
     * @var string
     */
    private string $fileName;

    /**
     * XlsxResponseService constructor.
     * @param string $tempFile
     * @param string $fileName
     */
    private function __construct(string $tempFile, string $fileName)
    {
        $this->tempFile = $tempFile;
        $this->fileName = $fileName;
    }

    /**
     * @param string $tempFile
     * @param string $fileName
     * @return XlsxResponseService
     */
    public static function instance(string $tempFile, string $fileName): self
    {
        return new self($tempFile, $fileName);
    }

    /**
     * @return string
     */
    public function getTempFile(): string
    {
        return $this->tempFile;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
