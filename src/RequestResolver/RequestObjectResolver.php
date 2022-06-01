<?php

declare(strict_types=1);


namespace App\RequestResolver;

use App\Infrastructure\Exceptions\InvalidRequestData;
use App\Infrastructure\ObjectResolver\DataObject;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestObjectResolver
 * @package App\RequestResolver
 */
class RequestObjectResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * RequestObjectResolver constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param Security $security
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Security $security
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return is_subclass_of($argument->getType(), DataObject::class);
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return Generator
     * @throws InvalidRequestData
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $data = $request->attributes->get('_route_params') + $request->request->all() + $request->query->all();

        if ($user = $this->security->getUser()) {
            $data['modifiedId'] = $user->getId();
            $data['modifiedCompany'] = $user->getCompany();
        }

        $dto = $this->serializer->denormalize($data, $argument->getType(), null, [
            'disable_type_enforcement' => true,
        ]);

        $this->validateDTO($dto);

        yield $dto;
    }

    /**
     * @param $dto
     * @throws InvalidRequestData
     */
    private function validateDTO($dto)
    {
        $errors = $this->validator->validate($dto);

        if (0 !== count($errors)) {
            throw new InvalidRequestData($errors);
        }
    }
}
