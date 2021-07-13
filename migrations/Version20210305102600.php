<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305102600 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE therapist ADD institution_id INT NOT NULL');
        $this->addSql('ALTER TABLE therapist ADD CONSTRAINT FK_C3D632F10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('CREATE INDEX IDX_C3D632F10405986 ON therapist (institution_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE therapist DROP FOREIGN KEY FK_C3D632F10405986');
        $this->addSql('DROP INDEX IDX_C3D632F10405986 ON therapist');
        $this->addSql('ALTER TABLE therapist DROP institution_id');
    }
}
