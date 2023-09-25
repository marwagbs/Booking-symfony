<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121131450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room_bed ADD bed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_bed ADD CONSTRAINT FK_E4C141E288688BB9 FOREIGN KEY (bed_id) REFERENCES bed (id)');
        $this->addSql('CREATE INDEX IDX_E4C141E288688BB9 ON room_bed (bed_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room_bed DROP FOREIGN KEY FK_E4C141E288688BB9');
        $this->addSql('DROP INDEX IDX_E4C141E288688BB9 ON room_bed');
        $this->addSql('ALTER TABLE room_bed DROP bed_id');
    }
}
