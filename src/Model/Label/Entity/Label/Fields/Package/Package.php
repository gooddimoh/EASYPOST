<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields\Package;

use App\Infrastructure\Events\AggregateRoot;
use App\Infrastructure\Services\UuidGenerator;
use App\Model\Label\Entity\Label\Label;
use App\Model\Label\Entity\Label\Fields\Package\Fields\{
    Price,
    Weight,
    Creator,
    Quantity,
    Description,
};
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * Class Package
 * @package App\Model\Label\Entity\Label
 *
 * @ORM\Entity
 * @ORM\Table(name="label_label_packages")
 */
class Package extends AggregateRoot
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;

    /**
     * @var Price
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Package\Fields\Price")
     */
    private Price $price;

    /**
     * @var Weight
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Package\Fields\Weight")
     */
    private Weight $weight;

    /**
     * @var Description
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Package\Fields\Description")
     */
    private Description $description;

    /**
     * @var Quantity
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Package\Fields\Quantity")
     */
    private Quantity $quantity;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Package\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Label\Entity\Label\Label", inversedBy="packages")
     * @ORM\JoinColumn(name="label_label_id", referencedColumnName="id", nullable=false)
     * @var Label
     */
    private Label $label;

    /**
     * Package constructor.
     * @param Price $price
     * @param Weight $weight
     * @param Quantity $quantity
     * @param Description $description
     * @param Creator $creator
     * @param DateTimeImmutable $date
     * @param Label $label
     * @throws \Exception
     */
    public function __construct(
        Price $price,
        Weight $weight,
        Quantity $quantity,
        Description $description,
        Creator $creator,
        DateTimeImmutable $date,
        Label $label
    )
    {
        $this->id = UuidGenerator::generate();
        $this->price = $price;
        $this->weight = $weight;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->user = $creator;
        $this->date = $date;
        $this->label = $label;
    }

    /**
     * @param Package $address
     * @return bool
     */
    public function isEqual(Package $address): bool
    {
        return $this->getId() === $address->getId();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Weight
     */
    public function getWeight(): Weight
    {
        return $this->weight;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Creator
     */
    public function getUser(): Creator
    {
        return $this->user;
    }

    /**
     * @return Quantity
     */
    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    /**
     * @return Label
     */
    public function getLabel(): Label
    {
        return $this->label;
    }
}
