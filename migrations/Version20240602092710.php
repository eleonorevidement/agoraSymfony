<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602092710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders CHANGE cvc cvv INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD cvv INT NOT NULL, DROP cvc, DROP country, DROP phone_number, DROP background_image, CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE payment_method payment_method VARCHAR(255) NOT NULL, CHANGE card_number card_number VARCHAR(255) NOT NULL, CHANGE expiration_date expiration_date VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders CHANGE cvv cvc INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD cvc VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL, ADD background_image VARCHAR(255) DEFAULT NULL, DROP cvv, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE payment_method payment_method VARCHAR(255) DEFAULT NULL, CHANGE card_number card_number VARCHAR(255) DEFAULT NULL, CHANGE expiration_date expiration_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
