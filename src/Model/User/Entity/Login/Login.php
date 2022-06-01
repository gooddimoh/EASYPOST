<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Login;

use App\Infrastructure\Events\AggregateRoot;
use App\Infrastructure\Services\UuidGenerator;
use App\Model\User\Entity\Login\Fields\{Browser, City, Country, IpAddress, Session, User};
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;

/**
 * Class Login
 * @package App\Model\User\Entity\Login
 *
 * @ORM\Entity
 * @ORM\Table(name="user_user_logins")
 */
class Login extends AggregateRoot
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;

    /**
     * @var User
     * @ORM\Embedded(class="App\Model\User\Entity\Login\Fields\User")
     */
    private User $user;

    /**
     * @var Session
     * @ORM\Embedded(class="App\Model\User\Entity\Login\Fields\Session")
     */
    private Session $session;

    /**
     * @var IpAddress
     * @ORM\Embedded(class="App\Model\User\Entity\Login\Fields\IpAddress")
     */
    private IpAddress $ipAddress;

    /**
     * @var Browser
     * @ORM\Embedded(class="App\Model\User\Entity\Login\Fields\Browser")
     */
    private Browser $browser;

    /**
     * @var Country
     * @ORM\Embedded(class="App\Model\User\Entity\Login\Fields\Country")
     */
    private Country $country;

    /**
     * @var City
     * @ORM\Embedded(class="App\Model\User\Entity\Login\Fields\City")
     */
    private City $city;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * Login constructor.
     * @param User $user
     * @param Session $session
     * @param IpAddress $ipAddress
     * @param Browser $browser
     * @param Country $country
     * @param City $city
     * @param DateTimeImmutable $date
     * @throws Exception
     */
    public function __construct(
        User $user,
        Session $session,
        IpAddress $ipAddress,
        Browser $browser,
        Country $country,
        City $city,
        DateTimeImmutable $date
    )
    {
        $this->id = UuidGenerator::generate();
        $this->user = $user;
        $this->session = $session;
        $this->ipAddress = $ipAddress;
        $this->browser = $browser;
        $this->country = $country;
        $this->city = $city;
        $this->date = $date;

//        $this->recordEvent(new EventUserLogin($this->getSession()->getValue()));
    }

    /**
     * @param Country $country
     */
    public function changeCountry(Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @param City $city
     */
    public function changeCity(City $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @return IpAddress
     */
    public function getIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }

    /**
     * @return Browser
     */
    public function getBrowser(): Browser
    {
        return $this->browser;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
