<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212134536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE listening_session (id SERIAL NOT NULL, album_id INT NOT NULL, listened BOOLEAN NOT NULL, choice_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E0EE8CB81137ABCF ON listening_session (album_id)');
        $this->addSql('COMMENT ON COLUMN listening_session.choice_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE listening_session ADD CONSTRAINT FK_E0EE8CB81137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE listening_session DROP CONSTRAINT FK_E0EE8CB81137ABCF');
        $this->addSql('DROP TABLE listening_session');
    }
}
