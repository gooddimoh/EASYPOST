<?php

declare(strict_types=1);


namespace App\Normalizer;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ConstraintViolationListNormalizer
 * @package App\Normalizer
 */
class HttpExceptionNormalizer implements NormalizerInterface
{
    /**
     * @param HttpException $object
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, $format = null, array $context = array()): array
    {
        return [
            'status' => false,
            'errors' => [
                'code' => 5000,
                'title' => Response::$statusTexts[$object->getStatusCode()],
                'detail' => $object->getMessage(),
            ],
        ];
    }

    /**
     * @param mixed $data
     * @param null $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof HttpException;
    }
}
