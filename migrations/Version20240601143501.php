<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601143501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD payment_method VARCHAR(255) NOT NULL, ADD card_number VARCHAR(255) NOT NULL, ADD cvc INT NOT NULL, ADD expiration_date VARCHAR(255) NOT NULL, ADD address LONGTEXT NOT NULL, ADD postal_code INT NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL, ADD phone_number INT NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE orders ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP payment_method, DROP card_number, DROP cvc, DROP expiration_date, DROP address, DROP postal_code, DROP city, DROP country, DROP phone_number');
    }
}
