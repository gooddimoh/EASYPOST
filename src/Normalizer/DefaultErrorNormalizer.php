<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Exceptions\MiscommunicationException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Doctrine\DBAL\Exception;

/**
 * Class TypeErrorNormalizer
 * @package App\Normalizer
 */
class DefaultErrorNormalizer implements NormalizerInterface
{
    /**
     * @param mixed $object
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, $format = null, array $context = array()): array
    {
        return [
            'status' => false,
            'errors' => [
                'code' => $context['code'] ?? 1000,
                'title' => 'Invalid request parameter.',
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
        return
            ($data instanceof \TypeError) ||
            ($data instanceof \InvalidArgumentException) ||
            ($data instanceof \ErrorException) ||
            ($data instanceof \DomainException) ||
            ($data instanceof EntityNotFoundException) ||
            ($data instanceof InvalidRequestParameter) ||
            ($data instanceof MiscommunicationException) ||
            ($data instanceof NotNormalizableValueException) ||
            ($data instanceof Exception);
    }
}
