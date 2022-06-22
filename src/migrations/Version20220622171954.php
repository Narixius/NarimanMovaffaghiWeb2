<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622171954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3535ED9B03A8386 ON hotel (created_by_id)');
        $this->addSql('CREATE INDEX IDX_3535ED9896DBBDE ON hotel (updated_by_id)');
        $this->addSql('ALTER TABLE user ADD deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9B03A8386');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9896DBBDE');
        $this->addSql('DROP INDEX IDX_3535ED9B03A8386 ON hotel');
        $this->addSql('DROP INDEX IDX_3535ED9896DBBDE ON hotel');
        $this->addSql('ALTER TABLE user DROP deleted_at');
    }
}
