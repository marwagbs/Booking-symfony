<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121132730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room ADD accomodation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BFD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('CREATE INDEX IDX_729F519BFD70509C ON room (accomodation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BFD70509C');
        $this->addSql('DROP INDEX IDX_729F519BFD70509C ON room');
        $this->addSql('ALTER TABLE room DROP accomodation_id');
    }
}
