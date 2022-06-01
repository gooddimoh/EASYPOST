<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Uploader;

/**
 * Class File
 * @package App\Infrastructure\Services\Uploader
 */
class File
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $realName;

    /**
     * @var int
     */
    private $size;

    /**
     * File constructor.
     * @param string $path
     * @param string $name
     * @param string $realName
     * @param int $size
     */
    public function __construct(string $path, string $name, string $realName, int $size)
    {
        $this->path = $path;
        $this->name = $name;
        $this->realName = $realName;
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRealName(): string
    {
        return $this->realName;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }
}