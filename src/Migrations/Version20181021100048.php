<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181021100048 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE news (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, date DATETIME NOT NULL, author VARCHAR(255) NOT NULL, image CLOB DEFAULT NULL)');
        $this->addSql('DROP INDEX IDX_794381C616A2B381');
        $this->addSql('CREATE TEMPORARY TABLE __temp__review AS SELECT id, book_id, rating, body, author, publication_date FROM review');
        $this->addSql('DROP TABLE review');
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER DEFAULT NULL, rating SMALLINT NOT NULL, body CLOB NOT NULL COLLATE BINARY, author VARCHAR(255) NOT NULL COLLATE BINARY, publication_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_794381C616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO review (id, book_id, rating, body, author, publication_date) SELECT id, book_id, rating, body, author, publication_date FROM __temp__review');
        $this->addSql('DROP TABLE __temp__review');
        $this->addSql('CREATE INDEX IDX_794381C616A2B381 ON review (book_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE news');
        $this->addSql('DROP INDEX IDX_794381C616A2B381');
        $this->addSql('CREATE TEMPORARY TABLE __temp__review AS SELECT id, book_id, rating, body, author, publication_date FROM review');
        $this->addSql('DROP TABLE review');
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER DEFAULT NULL, rating SMALLINT NOT NULL, body CLOB NOT NULL, author VARCHAR(255) NOT NULL, publication_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO review (id, book_id, rating, body, author, publication_date) SELECT id, book_id, rating, body, author, publication_date FROM __temp__review');
        $this->addSql('DROP TABLE __temp__review');
        $this->addSql('CREATE INDEX IDX_794381C616A2B381 ON review (book_id)');
    }
}
