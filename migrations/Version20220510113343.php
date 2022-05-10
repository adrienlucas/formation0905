<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220510113343 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, description, release_date FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, genre_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, release_date DATE NOT NULL, CONSTRAINT FK_1D5EF26F4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO movie (id, title, description, release_date) SELECT id, title, description, release_date FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
        $this->addSql('CREATE INDEX IDX_1D5EF26F4296D31F ON movie (genre_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP INDEX IDX_1D5EF26F4296D31F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, description, release_date FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, release_date DATE NOT NULL)');
        $this->addSql('INSERT INTO movie (id, title, description, release_date) SELECT id, title, description, release_date FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
