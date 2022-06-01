<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Uploader;

use League\Flysystem\FilesystemInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileUploader
 * @package App\Infrastructure\Services\Uploader
 */
class FileUploader
{
    /**
     * @var FilesystemInterface
     */
    private $storage;

    /**
     * @var string
     */
    private $basUrl;

    /**
     * FileUploader constructor.
     * @param FilesystemInterface $storage
     * @param string $basUrl
     */
    public function __construct(FilesystemInterface $storage, string $basUrl)
    {
        $this->storage = $storage;
        $this->basUrl = $basUrl;
    }

    /**
     * @param UploadedFile $file
     * @return File
     * @throws \League\Flysystem\FileExistsException
     */
    public function upload(UploadedFile $file): File
    {
        $path = date('Y/m/d');
        $name = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();
        $stream = fopen($file->getRealPath(), 'rb+');
        $this->storage->writeStream($path . '/' . $name, $stream);
        fclose($stream);

        return new File($path, $name, $file->getClientOriginalName(), $file->getSize());
    }

    /**
     * @param string $path
     * @return string
     */
    public function generateUrl(string $path): string
    {
        return $this->basUrl . '/' . $path;
    }

    /**
     * @param string $path
     * @param string $name
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function remove(string $path, string $name): void
    {
        $this->storage->delete($path . '/' . $name);
    }
}