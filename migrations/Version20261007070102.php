<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261007070102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, numero_inventaire VARCHAR(20) NOT NULL, type VARCHAR(30) NOT NULL, site VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ticket_materiel (ticket_id INT NOT NULL, materiel_id INT NOT NULL, INDEX IDX_9DBB4C10700047D2 (ticket_id), INDEX IDX_9DBB4C1016880AAF (materiel_id), PRIMARY KEY (ticket_id, materiel_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE ticket_materiel ADD CONSTRAINT FK_9DBB4C10700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_materiel ADD CONSTRAINT FK_9DBB4C1016880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3BCF5E72D ON ticket (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_materiel DROP FOREIGN KEY FK_9DBB4C10700047D2');
        $this->addSql('ALTER TABLE ticket_materiel DROP FOREIGN KEY FK_9DBB4C1016880AAF');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE ticket_materiel');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3BCF5E72D');
        $this->addSql('DROP INDEX IDX_97A0ADA3BCF5E72D ON ticket');
        $this->addSql('ALTER TABLE ticket DROP categorie_id');
    }
}
