<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826215120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_4B91E702A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comentario AS SELECT id, user_id, comentario, fecha_publicacion FROM comentario');
        $this->addSql('DROP TABLE comentario');
        $this->addSql('CREATE TABLE comentario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, post_id INTEGER DEFAULT NULL, comentario VARCHAR(255) NOT NULL COLLATE BINARY, fecha_publicacion DATE NOT NULL, CONSTRAINT FK_4B91E702A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4B91E7024B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comentario (id, user_id, comentario, fecha_publicacion) SELECT id, user_id, comentario, fecha_publicacion FROM __temp__comentario');
        $this->addSql('DROP TABLE __temp__comentario');
        $this->addSql('CREATE INDEX IDX_4B91E702A76ED395 ON comentario (user_id)');
        $this->addSql('CREATE INDEX IDX_4B91E7024B89032C ON comentario (post_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, user_id, titulo, likes, foto, fecha_publicacion, contenido FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, titulo VARCHAR(255) NOT NULL COLLATE BINARY, likes CLOB DEFAULT NULL COLLATE BINARY, foto VARCHAR(255) DEFAULT NULL COLLATE BINARY, fecha_publicacion DATETIME NOT NULL, contenido CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, user_id, titulo, likes, foto, fecha_publicacion, contenido) SELECT id, user_id, titulo, likes, foto, fecha_publicacion, contenido FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__profesion AS SELECT id, nombre FROM profesion');
        $this->addSql('DROP TABLE profesion');
        $this->addSql('CREATE TABLE profesion (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, nombre VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_7CBDAD0AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO profesion (id, nombre) SELECT id, nombre FROM __temp__profesion');
        $this->addSql('DROP TABLE __temp__profesion');
        $this->addSql('CREATE INDEX IDX_7CBDAD0AA76ED395 ON profesion (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_4B91E702A76ED395');
        $this->addSql('DROP INDEX IDX_4B91E7024B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comentario AS SELECT id, user_id, comentario, fecha_publicacion FROM comentario');
        $this->addSql('DROP TABLE comentario');
        $this->addSql('CREATE TABLE comentario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, comentario VARCHAR(255) NOT NULL, fecha_publicacion DATE NOT NULL)');
        $this->addSql('INSERT INTO comentario (id, user_id, comentario, fecha_publicacion) SELECT id, user_id, comentario, fecha_publicacion FROM __temp__comentario');
        $this->addSql('DROP TABLE __temp__comentario');
        $this->addSql('CREATE INDEX IDX_4B91E702A76ED395 ON comentario (user_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, user_id, titulo, likes, foto, fecha_publicacion, contenido FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, titulo VARCHAR(255) NOT NULL, likes CLOB DEFAULT NULL, foto VARCHAR(255) DEFAULT NULL, fecha_publicacion DATETIME NOT NULL, contenido CLOB NOT NULL)');
        $this->addSql('INSERT INTO post (id, user_id, titulo, likes, foto, fecha_publicacion, contenido) SELECT id, user_id, titulo, likes, foto, fecha_publicacion, contenido FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('DROP INDEX IDX_7CBDAD0AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__profesion AS SELECT id, nombre FROM profesion');
        $this->addSql('DROP TABLE profesion');
        $this->addSql('CREATE TABLE profesion (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO profesion (id, nombre) SELECT id, nombre FROM __temp__profesion');
        $this->addSql('DROP TABLE __temp__profesion');
    }
}
