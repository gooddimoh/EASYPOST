<?php

namespace App\Command;

use App\Infrastructure\Enums\Model\Carrier\NameEnum;
use App\Infrastructure\Enums\Model\Company\TypeEnum;
use App\Model\Company\Entity\Company\Company;
use App\Model\Label\Entity\Carrier\Carrier;
use App\Model\Label\Entity\Carrier\Fields\Id as CarrierId;
use App\Model\Label\Entity\Carrier\Fields\Name as CarrierName;
use App\Model\Label\Entity\Carrier\Fields\Type as CarrierType;
use App\Model\Label\Entity\Carrier\Fields\Status as CarrierStatus;
use App\Model\Label\Entity\Carrier\Fields\Creator as CarrierCreator;
use App\Model\Label\Entity\Carrier\Fields\CarrierAccount;
use App\Model\Label\Entity\Carrier\Fields\Credentials;
use App\Model\Label\Entity\Carrier\Fields\Custom;
use App\Model\Label\Entity\Carrier\Fields\Description;
use App\Model\Label\Entity\Carrier\Fields\Editable;
use App\Model\Company\Entity\Company\Fields\{
    Creator,
    Id,
    Name,
    Package,
    Photo,
    Status,
    Type
};
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\User\Entity\User\Fields\{
    Id as IdUser,
    Email as EmailUser,
    Name as NameUser,
    Status as StatusUser,
    Company as CompanyUser,
    Photo as PhotoUser,
    Creator as CreatorUser,
    PasswordHash as PasswordHashUser,
    Phone as PhoneUser,
    Role as RoleUser
};
use App\Model\User\Entity\User\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Model\User\Service\PasswordHasher;

class CreateRootCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:init';

    private EntityManagerInterface $manager;

    private PasswordHasher $hasher;

    private Id $companyId;

    private IdUser $userId;

    private string $rootEmail;

    private string $rootPassword;

    public function __construct(
        string                 $rootEmail,
        string                 $rootPassword,
        EntityManagerInterface $manager,
        PasswordHasher         $hasher
    ) {
        $this->manager = $manager;
        $this->hasher = $hasher;
        $this->rootEmail = $rootEmail;
        $this->rootPassword = $rootPassword;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $output->writeln([
                'Root company/user Creator',
            ]);

            $this->createCompanyUser();

            $output->writeln([
                'Created company/user success',
            ]);
            $output->writeln([
                '===========',
            ]);

            $output->writeln([
                'Carriers Creator',
            ]);

            $this->createCarrier();

            $output->writeln([
                'Created carriers success',
            ]);
            $output->writeln([
                '===========',
            ]);

        } catch (\Exception $e) {
            $output->writeln([
                $e->getMessage(),
                '===========',
            ]);
        }

        $output->writeln([
            'OK',
        ]);

        return Command::SUCCESS;
    }

    /**
     * @throws \Exception
     */
    private function createCompanyUser(): void
    {
        $this->companyId = Id::next();

        $company = new Company(
            $this->companyId,
            new Name("Root"),
            new Type(TypeEnum::COMPANY),
            new Photo(''),
            new Package(null),
            new Creator(null, null),
            new \DateTimeImmutable(),
            Status::active()
        );

        $this->manager->persist($company);

        $this->userId = IdUser::next();

        $user = new User(
            $this->userId,
            new NameUser("Root Root"),
            new PasswordHashUser($this->hasher->hash($this->rootPassword)),
            new CompanyUser($this->companyId->getValue()),
            new EmailUser($this->rootEmail),
            new PhoneUser('+380', '123456789'),
            new PhotoUser(''),
            new RoleUser('ROLE_ADMIN'),
            new CreatorUser(null),
            new \DateTimeImmutable(),
            StatusUser::active(),
        );

        $this->manager->persist($user);
        $this->manager->flush();
    }

    /**
     * @throws \Exception
     */
    private function createCarrier(): void
    {
        $carrierUPS = new Carrier(
            CarrierId::next(),
            new CarrierName(NameEnum::UPS),
            CarrierType::ups(),
            new Description(sprintf('%s carrier description', NameEnum::UPS)),
            new CarrierAccount('ca_9969fbdcdf29400ab80e35bcc90ea3b0'),
            new Credentials([
                'access_license_number' => 'unknown',
                'account_number' => 'unknown',
                'user_id' => 'unknown',
                'password' => 'unknown',
            ]),
            Custom::no(),
            Editable::yes(),
            CarrierStatus::active(),
            new DateTimeImmutable(),
            new CarrierCreator($this->userId->getValue(), $this->companyId->getValue())
        );

        $carrierFEDEX = new Carrier(
            CarrierId::next(),
            new CarrierName(NameEnum::FEDEX),
            CarrierType::fedex(),
            new Description(sprintf('%s carrier description', NameEnum::FEDEX)),
            new CarrierAccount('ca_37349283de2449f8b54d9dc173824204'),
            new Credentials([
                'account_number' => 'unknown',
                'meter_number' => 'unknown',
                'key' => 'unknown',
                'password' => 'unknown',
            ]),
            Custom::no(),
            Editable::yes(),
            CarrierStatus::active(),
            new DateTimeImmutable(),
            new CarrierCreator($this->userId->getValue(), $this->companyId->getValue())
        );

        $carrierUSPS = new Carrier(
            CarrierId::next(),
            new CarrierName(NameEnum::USPS),
            CarrierType::usps(),
            new Description(sprintf('%s carrier description', NameEnum::USPS)),
            new CarrierAccount('ca_0efbd04c5df543889835661a182fea40'),
            new Credentials([
                'account_number' => 'unknown',
                'meter_number' => 'unknown',
                'key' => 'unknown',
                'password' => 'unknown',
            ]),
            Custom::no(),
            Editable::no(),
            CarrierStatus::active(),
            new DateTimeImmutable(),
            new CarrierCreator($this->userId->getValue(), $this->companyId->getValue())
        );

        $this->manager->persist($carrierUPS);
        $this->manager->persist($carrierFEDEX);
        $this->manager->persist($carrierUSPS);

        $this->manager->flush();
    }
}
