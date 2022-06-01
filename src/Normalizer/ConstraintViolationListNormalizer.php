<?php

declare(strict_types=1);


namespace App\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ConstraintViolationListNormalizer
 * @package App\Normalizer
 */
class ConstraintViolationListNormalizer implements NormalizerInterface
{
    /**
     * @param object $object
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, $format = null, array $context = array()): array
    {
        /**
         * @var ConstraintViolationListInterface $object
         */
        [$messages, $violations] = $this->getMessagesAndViolations($object);

        return [
            'status' => false,
            'errors' => [
                'code' => 4000,
                'title' => $context['title'] ?? 'An error occurred',
                'detail' => $messages ? implode("\n", $messages) : '',
                'violations' => $violations,
            ],
        ];
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return array
     */
    private function getMessagesAndViolations(ConstraintViolationListInterface $constraintViolationList): array
    {
        $violations = $messages = [];
        /** @var ConstraintViolation $violation */
        foreach ($constraintViolationList as $violation) {
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
            $propertyPath = $violation->getPropertyPath();
            $messages[] = ($propertyPath ? $propertyPath . ': ' : '') . $violation->getMessage();
        }

        return [$messages, $violations];
    }

    /**
     * @param mixed $data
     * @param null $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof ConstraintViolationListInterface;
    }
}
