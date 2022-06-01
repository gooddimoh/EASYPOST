<?php

declare(strict_types=1);

namespace App\Twig;

use App\Infrastructure\Enums\Model\User\StatusEnum;
use App\Security\UserIdentity;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class ReduxStoreArguments
 *
 * @package App\Twig
 */
class ReduxStoreArguments extends AbstractExtension
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var UserIdentity
     */
    protected $user;

    /**
     * ReduxStoreArguments constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->user = $security->getUser();
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('redux_store_arguments', [$this, 'handle']),
        ];
    }

    /**
     * @param array $items
     *
     * @return array
     */
    public function handle(array $items): array
    {
        return $this->user ?
            $this->appendStoreArguments($items) :
            $items;
    }

    /**
     * @param array $items
     *
     * @return array
     */
    public function appendStoreArguments(array $items): array
    {
        $items = array_merge($items, [
            'user' => [
                'id' => $this->user->getId(),
                'fullName' => $this->user->getFullName(),
                'photo' => $this->user->getPhoto(),
                'permissions' => $this->user->getRoles(),
                'company' => $this->user->getCompany(),
                'companyName' => $this->user->getCompanyName(),
                'email' => $this->user->getUsername(),
                'companyType' => $this->user->getCompanyType(),
                'activePackage' => $this->user->getActivePackage(),
                'confirmed' => $this->user->getStatus() === StatusEnum::ACTIVE,
            ]
        ]);

        return $items;
    }
}
