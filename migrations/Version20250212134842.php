<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212134842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE listening_context (id SERIAL NOT NULL, session_id INT NOT NULL, day_of_week VARCHAR(255) NOT NULL, time_of_day VARCHAR(255) NOT NULL, season VARCHAR(255) NOT NULL, mood VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D2F7DC12613FECDF ON listening_context (session_id)');
        $this->addSql('ALTER TABLE listening_context ADD CONSTRAINT FK_D2F7DC12613FECDF FOREIGN KEY (session_id) REFERENCES listening_session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE listening_context DROP CONSTRAINT FK_D2F7DC12613FECDF');
        $this->addSql('DROP TABLE listening_context');
    }
}
