<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212094222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album_mood (album_id INT NOT NULL, mood_id INT NOT NULL, PRIMARY KEY(album_id, mood_id))');
        $this->addSql('CREATE INDEX IDX_673218B61137ABCF ON album_mood (album_id)');
        $this->addSql('CREATE INDEX IDX_673218B6B889D33E ON album_mood (mood_id)');
        $this->addSql('ALTER TABLE album_mood ADD CONSTRAINT FK_673218B61137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album_mood ADD CONSTRAINT FK_673218B6B889D33E FOREIGN KEY (mood_id) REFERENCES mood (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE album_mood DROP CONSTRAINT FK_673218B61137ABCF');
        $this->addSql('ALTER TABLE album_mood DROP CONSTRAINT FK_673218B6B889D33E');
        $this->addSql('DROP TABLE album_mood');
    }
}
