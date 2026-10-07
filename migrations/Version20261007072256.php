<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261007072256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(80) NOT NULL, prenom VARCHAR(80) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE ticket ADD auteur_id INT NOT NULL, ADD technicien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA360BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA313457256 FOREIGN KEY (technicien_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA360BB6FE6 ON ticket (auteur_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA313457256 ON ticket (technicien_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA360BB6FE6');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA313457256');
        $this->addSql('DROP INDEX IDX_97A0ADA360BB6FE6 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA313457256 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP auteur_id, DROP technicien_id');
    }
}
