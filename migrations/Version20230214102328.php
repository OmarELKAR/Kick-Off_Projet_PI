<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214102328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournoi (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nbr_equipe INT NOT NULL, date DATE NOT NULL, etat VARCHAR(20) NOT NULL, nbr_jequipe INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matche ADD tournoi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD510F607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id)');
        $this->addSql('CREATE INDEX IDX_9FCAD510F607770A ON matche (tournoi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matche DROP FOREIGN KEY FK_9FCAD510F607770A');
        $this->addSql('DROP TABLE tournoi');
        $this->addSql('DROP INDEX IDX_9FCAD510F607770A ON matche');
        $this->addSql('ALTER TABLE matche DROP tournoi_id');
    }
}
