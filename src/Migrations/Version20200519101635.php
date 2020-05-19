<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519101635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(45) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_11BA68C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, tasklist_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, term DATETIME DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_5058659712469DE2 (category_id), INDEX IDX_50586597FF3475DB (tasklist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasklists (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(45) NOT NULL, term DATETIME DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_26B07BC512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasklistalarms (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasklistpriorities (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659712469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597FF3475DB FOREIGN KEY (tasklist_id) REFERENCES tasklists (id)');
        $this->addSql('ALTER TABLE tasklists ADD CONSTRAINT FK_26B07BC512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C12469DE2');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_5058659712469DE2');
        $this->addSql('ALTER TABLE tasklists DROP FOREIGN KEY FK_26B07BC512469DE2');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597FF3475DB');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE tasklists');
        $this->addSql('DROP TABLE tasklistalarms');
        $this->addSql('DROP TABLE tasklistpriorities');
    }
}
