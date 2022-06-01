<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210817091555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE failure_login_attempt_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE company_companies (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name_value VARCHAR(255) DEFAULT NULL, photo_value VARCHAR(255) NOT NULL, type_value SMALLINT NOT NULL, status_value SMALLINT NOT NULL, company_package_id UUID DEFAULT NULL, user_user_id UUID DEFAULT NULL, company_company_id UUID DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN company_companies.id IS \'(DC2Type:company_company_id)\'');
        $this->addSql('COMMENT ON COLUMN company_companies.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE company_company_balances (id UUID NOT NULL, company_company_id UUID NOT NULL, total INT NOT NULL, lock INT NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77CB0DD92A15F340 ON company_company_balances (company_company_id)');
        $this->addSql(
            'COMMENT ON COLUMN company_company_balances.company_company_id IS \'(DC2Type:company_company_id)\''
        );
        $this->addSql(
            'CREATE TABLE company_company_transactions (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description_value VARCHAR(255) NOT NULL, balance_history INT NOT NULL, balance_value INT NOT NULL, status_value SMALLINT NOT NULL, type_value SMALLINT NOT NULL, type_method SMALLINT DEFAULT NULL, type_options JSON DEFAULT NULL, user_user_id UUID NOT NULL, company_company_id UUID NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN company_company_transactions.id IS \'(DC2Type:company_transaction_id)\'');
        $this->addSql('COMMENT ON COLUMN company_company_transactions.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE company_packages (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name_value VARCHAR(255) NOT NULL, available_company_value UUID DEFAULT NULL, price_month INT NOT NULL, price_label INT NOT NULL, price_additional INT NOT NULL, permissions_value JSON NOT NULL, status_value SMALLINT NOT NULL, user_user_id UUID NOT NULL, company_company_id UUID NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN company_packages.id IS \'(DC2Type:company_package_id)\'');
        $this->addSql('COMMENT ON COLUMN company_packages.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE failure_login_attempt (id INT NOT NULL, ip VARCHAR(45) NOT NULL, username VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, data TEXT NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX ip ON failure_login_attempt (ip)');
        $this->addSql('COMMENT ON COLUMN failure_login_attempt.data IS \'(DC2Type:array)\'');
        $this->addSql(
            'CREATE TABLE label_address_books (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name_value VARCHAR(255) NOT NULL, type_record SMALLINT NOT NULL, type_address SMALLINT NOT NULL, contact_code VARCHAR(10) DEFAULT NULL, contact_phone VARCHAR(20) DEFAULT NULL, contact_email VARCHAR(50) DEFAULT NULL, address_street1 VARCHAR(255) NOT NULL, address_street2 VARCHAR(255) DEFAULT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(255) NOT NULL, address_country VARCHAR(255) NOT NULL, address_zip VARCHAR(255) NOT NULL, description_value VARCHAR(255) DEFAULT NULL, status_value SMALLINT NOT NULL, user_user_id UUID NOT NULL, company_company_id UUID NOT NULL, options_value JSON NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN label_address_books.id IS \'(DC2Type:label_address_book_id)\'');
        $this->addSql('COMMENT ON COLUMN label_address_books.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE label_carriers (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name_value VARCHAR(255) NOT NULL, type_value VARCHAR(255) NOT NULL, status_value SMALLINT NOT NULL, carrier_account_value VARCHAR(255) NOT NULL, credentials_value JSON NOT NULL, custom_value BOOLEAN NOT NULL, description_value VARCHAR(255) NOT NULL, editable_value BOOLEAN NOT NULL, company_company_id UUID NOT NULL, user_user_id UUID NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN label_carriers.id IS \'(DC2Type:label_carrier_id)\'');
        $this->addSql('COMMENT ON COLUMN label_carriers.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE label_label_packages (id UUID NOT NULL, label_label_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price_value INT NOT NULL, weight_value NUMERIC(10, 2) NOT NULL, description_value VARCHAR(255) DEFAULT NULL, quantity_value INT NOT NULL, user_user_id UUID NOT NULL, company_company_id UUID NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_66AF8D0B71B736FC ON label_label_packages (label_label_id)');
        $this->addSql('COMMENT ON COLUMN label_label_packages.label_label_id IS \'(DC2Type:label_label_id)\'');
        $this->addSql('COMMENT ON COLUMN label_label_packages.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE label_labels (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type_value SMALLINT NOT NULL, shipment_id VARCHAR(255) DEFAULT NULL, shipment_price INT DEFAULT NULL, shipment_rate_id VARCHAR(255) DEFAULT NULL, pickup_id VARCHAR(255) DEFAULT NULL, pickup_price INT DEFAULT NULL, pickup_rate_id VARCHAR(255) DEFAULT NULL, parcel_height NUMERIC(10, 2) DEFAULT NULL, parcel_length NUMERIC(10, 2) DEFAULT NULL, parcel_weight NUMERIC(10, 2) NOT NULL, parcel_width NUMERIC(10, 2) DEFAULT NULL, sender_name VARCHAR(255) NOT NULL, sender_type SMALLINT NOT NULL, sender_code VARCHAR(10) DEFAULT NULL, sender_phone VARCHAR(20) DEFAULT NULL, sender_email VARCHAR(50) DEFAULT NULL, sender_street1 VARCHAR(255) NOT NULL, sender_street2 VARCHAR(255) DEFAULT NULL, sender_city VARCHAR(255) NOT NULL, sender_state VARCHAR(255) NOT NULL, sender_country VARCHAR(255) NOT NULL, sender_zip VARCHAR(255) NOT NULL, recipient_name VARCHAR(255) NOT NULL, recipient_type SMALLINT NOT NULL, recipient_code VARCHAR(10) DEFAULT NULL, recipient_phone VARCHAR(20) DEFAULT NULL, recipient_email VARCHAR(50) DEFAULT NULL, recipient_street1 VARCHAR(255) NOT NULL, recipient_street2 VARCHAR(255) DEFAULT NULL, recipient_city VARCHAR(255) NOT NULL, recipient_state VARCHAR(255) NOT NULL, recipient_country VARCHAR(255) NOT NULL, recipient_zip VARCHAR(255) NOT NULL, information_service VARCHAR(255) DEFAULT NULL, information_carrier VARCHAR(255) DEFAULT NULL, information_track VARCHAR(255) DEFAULT NULL, information_label_url VARCHAR(255) DEFAULT NULL, information_track_url VARCHAR(255) DEFAULT NULL, description_value VARCHAR(255) DEFAULT NULL, status_value SMALLINT NOT NULL, user_user_id UUID NOT NULL, company_company_id UUID NOT NULL, options_value JSON NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN label_labels.id IS \'(DC2Type:label_label_id)\'');
        $this->addSql('COMMENT ON COLUMN label_labels.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE stripe_charges (id UUID NOT NULL, user_id UUID DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, customer_value UUID NOT NULL, transaction_value UUID NOT NULL, company_value UUID NOT NULL, stripe_id_value VARCHAR(255) NOT NULL, amount_value INT NOT NULL, status_value SMALLINT NOT NULL, data_value JSON NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_152861E0A76ED395 ON stripe_charges (user_id)');
        $this->addSql('COMMENT ON COLUMN stripe_charges.id IS \'(DC2Type:stripe_charge_id)\'');
        $this->addSql('COMMENT ON COLUMN stripe_charges.user_id IS \'(DC2Type:user_user_id)\'');
        $this->addSql('COMMENT ON COLUMN stripe_charges.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE stripe_customers (id UUID NOT NULL, user_id UUID DEFAULT NULL, stripe_id_value VARCHAR(255) NOT NULL, bank_account_token_value VARCHAR(255) DEFAULT NULL, type_value SMALLINT NOT NULL, status_value SMALLINT NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_DDDE68EBA76ED395 ON stripe_customers (user_id)');
        $this->addSql('COMMENT ON COLUMN stripe_customers.id IS \'(DC2Type:stripe_customer_id)\'');
        $this->addSql('COMMENT ON COLUMN stripe_customers.user_id IS \'(DC2Type:user_user_id)\'');
        $this->addSql(
            'CREATE TABLE user_user_logins (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_user_id UUID NOT NULL, session_value VARCHAR(40) DEFAULT NULL, ip_address_value VARCHAR(45) DEFAULT NULL, browser_value VARCHAR(30) DEFAULT NULL, country_value VARCHAR(255) DEFAULT NULL, city_value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN user_user_logins.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE user_user_socials (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_user_id UUID NOT NULL, social_id_value VARCHAR(255) NOT NULL, type_value SMALLINT NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN user_user_socials.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE user_users (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name_value VARCHAR(255) DEFAULT NULL, reset_token_token VARCHAR(255) DEFAULT NULL, reset_token_expires TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, photo_value VARCHAR(255) NOT NULL, company_company_id UUID DEFAULT NULL, email_value VARCHAR(50) NOT NULL, password_hash_value VARCHAR(255) NOT NULL, phone_code VARCHAR(10) NOT NULL, phone_number VARCHAR(20) NOT NULL, status_value SMALLINT NOT NULL, user_user_id UUID DEFAULT NULL, role_value VARCHAR(20) NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql(
            'CREATE UNIQUE INDEX UNIQ_F6415EB1803A19BB ON user_users (email_value) WHERE (status_value = 10)'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB186EC69F0 ON user_users (reset_token_token)');
        $this->addSql('COMMENT ON COLUMN user_users.id IS \'(DC2Type:user_user_id)\'');
        $this->addSql('COMMENT ON COLUMN user_users.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.reset_token_expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql(
            'CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;'
        );
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql(
            'CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();'
        );
        $this->addSql(
            'ALTER TABLE company_company_balances ADD CONSTRAINT FK_77CB0DD92A15F340 FOREIGN KEY (company_company_id) REFERENCES company_companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE label_label_packages ADD CONSTRAINT FK_66AF8D0B71B736FC FOREIGN KEY (label_label_id) REFERENCES label_labels (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE stripe_charges ADD CONSTRAINT FK_152861E0A76ED395 FOREIGN KEY (user_id) REFERENCES user_users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE stripe_customers ADD CONSTRAINT FK_DDDE68EBA76ED395 FOREIGN KEY (user_id) REFERENCES user_users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_company_balances DROP CONSTRAINT FK_77CB0DD92A15F340');
        $this->addSql('ALTER TABLE label_label_packages DROP CONSTRAINT FK_66AF8D0B71B736FC');
        $this->addSql('ALTER TABLE stripe_charges DROP CONSTRAINT FK_152861E0A76ED395');
        $this->addSql('ALTER TABLE stripe_customers DROP CONSTRAINT FK_DDDE68EBA76ED395');
        $this->addSql('DROP SEQUENCE failure_login_attempt_id_seq CASCADE');
        $this->addSql('DROP TABLE company_companies');
        $this->addSql('DROP TABLE company_company_balances');
        $this->addSql('DROP TABLE company_company_transactions');
        $this->addSql('DROP TABLE company_packages');
        $this->addSql('DROP TABLE failure_login_attempt');
        $this->addSql('DROP TABLE label_address_books');
        $this->addSql('DROP TABLE label_carriers');
        $this->addSql('DROP TABLE label_label_packages');
        $this->addSql('DROP TABLE label_labels');
        $this->addSql('DROP TABLE stripe_charges');
        $this->addSql('DROP TABLE stripe_customers');
        $this->addSql('DROP TABLE user_user_logins');
        $this->addSql('DROP TABLE user_user_socials');
        $this->addSql('DROP TABLE user_users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
