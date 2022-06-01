<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825145953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE news_news (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title_value VARCHAR(255) NOT NULL, photo_value VARCHAR(255) NOT NULL, description_value VARCHAR(255) NOT NULL, link_value VARCHAR(255) NOT NULL, status_value SMALLINT NOT NULL, user_user_id UUID NOT NULL, company_company_id UUID NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN news_news.id IS \'(DC2Type:news_news_id)\'');
        $this->addSql('COMMENT ON COLUMN news_news.date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE news_news');
    }
}
