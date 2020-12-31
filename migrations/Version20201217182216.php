<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217182216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, boites_id INT DEFAULT NULL, carburations_id INT NOT NULL, couleurs_id INT NOT NULL, etats_id INT NOT NULL, marques_id INT NOT NULL, slug VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, chevaux INT NOT NULL, version VARCHAR(255) NOT NULL, porte INT NOT NULL, prix DOUBLE PRECISION NOT NULL, annee INT NOT NULL, kilometre INT NOT NULL, description LONGTEXT NOT NULL, publie TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_95C71D14989D9B62 (slug), INDEX IDX_95C71D14A292A217 (boites_id), INDEX IDX_95C71D14B44CB626 (carburations_id), INDEX IDX_95C71D145ED47289 (couleurs_id), INDEX IDX_95C71D14CA7E0C2E (etats_id), INDEX IDX_95C71D14C256483C (marques_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, cars_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E01FBE6A8702F506 (cars_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14A292A217 FOREIGN KEY (boites_id) REFERENCES boites (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14B44CB626 FOREIGN KEY (carburations_id) REFERENCES carburations (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D145ED47289 FOREIGN KEY (couleurs_id) REFERENCES couleurs (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14CA7E0C2E FOREIGN KEY (etats_id) REFERENCES etats (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14C256483C FOREIGN KEY (marques_id) REFERENCES marques (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8702F506 FOREIGN KEY (cars_id) REFERENCES cars (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8702F506');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE images');
    }
}
