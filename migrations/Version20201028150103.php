<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028150103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE telephonic_operator (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, subscribers INT NOT NULL, year_incomes DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone ADD telephonic_operator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DDF074FDE1 FOREIGN KEY (telephonic_operator_id) REFERENCES telephonic_operator (id)');
        $this->addSql('CREATE INDEX IDX_444F97DDF074FDE1 ON phone (telephonic_operator_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DDF074FDE1');
        $this->addSql('DROP TABLE telephonic_operator');
        $this->addSql('DROP INDEX IDX_444F97DDF074FDE1 ON phone');
        $this->addSql('ALTER TABLE phone DROP telephonic_operator_id');
    }
}
