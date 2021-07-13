<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408094237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sentence (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, text VARCHAR(255) DEFAULT NULL, audio VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_9D664ED56B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sentence_pictogram (sentence_id INT NOT NULL, pictogram_id INT NOT NULL, INDEX IDX_2C8F221A27289490 (sentence_id), INDEX IDX_2C8F221A16B7C33B (pictogram_id), PRIMARY KEY(sentence_id, pictogram_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sentence ADD CONSTRAINT FK_9D664ED56B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE sentence_pictogram ADD CONSTRAINT FK_2C8F221A27289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sentence_pictogram ADD CONSTRAINT FK_2C8F221A16B7C33B FOREIGN KEY (pictogram_id) REFERENCES pictogram (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sentence_pictogram DROP FOREIGN KEY FK_2C8F221A27289490');
        $this->addSql('DROP TABLE sentence');
        $this->addSql('DROP TABLE sentence_pictogram');
    }
}
