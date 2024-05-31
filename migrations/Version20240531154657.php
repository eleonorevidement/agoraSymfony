<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531154657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E61220EA6');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EB03A8386');
        $this->addSql('DROP INDEX IDX_1F1B251EB03A8386 ON item');
        $this->addSql('DROP INDEX IDX_1F1B251E61220EA6 ON item');
        $this->addSql('ALTER TABLE item ADD seller_id INT DEFAULT NULL, DROP created_by_id, DROP creator_id');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E8DE820D9 ON item (seller_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E8DE820D9');
        $this->addSql('DROP INDEX IDX_1F1B251E8DE820D9 ON item');
        $this->addSql('ALTER TABLE item ADD creator_id INT DEFAULT NULL, CHANGE seller_id created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1F1B251EB03A8386 ON item (created_by_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E61220EA6 ON item (creator_id)');
    }
}
