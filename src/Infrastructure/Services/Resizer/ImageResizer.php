<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Resizer;

use App\Infrastructure\Services\Uploader\File;
use App\Infrastructure\Services\Uploader\FileUploader;
use Gumlet\ImageResize;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImageResizer
 * @package App\Infrastructure\Services\Resizer
 */
class ImageResizer
{
    /**
     * @var ImageResize
     */
    private $resizer;

    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * ImageResizer constructor.
     * @param FileUploader $fileUploader
     */
    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param UploadedFile $image
     * @return ImageResizer
     * @throws \Gumlet\ImageResizeException
     */
    public function setImage(UploadedFile $image): self
    {
        $this->image = $image;
        $this->resizer = new ImageResize($image->getRealPath());

        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $allow_enlarge
     * @return ImageResizer
     */
    public function resize(int $width = 160, int $height = 160, bool $allow_enlarge = false): self
    {
        $this->resizer = $this->resizer->resize($width, $height, $allow_enlarge);

        return $this;
    }

    /**
     * @param int $max_width
     * @param int $max_height
     * @param bool $allow_enlarge
     * @return ImageResizer
     */
    public function resizeToBestFit(int $max_width = 160, int $max_height = 160, bool $allow_enlarge = false): self
    {
        $this->resizer = $this->resizer->resizeToBestFit($max_width, $max_height, $allow_enlarge);

        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $allow_enlarge
     * @param int $position
     * @return ImageResizer
     */
    public function crop(int $width = 160, int $height = 160,
                         bool $allow_enlarge = false, int $position = ImageResize::CROPCENTER): self
    {
        $this->resizer = $this->resizer->crop($width, $height, $allow_enlarge, $position);

        return $this;
    }

    /**
     * @param int $quality
     * @return File
     * @throws \Gumlet\ImageResizeException
     * @throws \League\Flysystem\FileExistsException
     */
    public function upload(int $quality = 80): File
    {
        $this->resizer->save($this->image->getRealPath(), null, $quality);

        return $this->fileUploader->upload($this->image);
    }
}