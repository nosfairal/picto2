<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324171156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD therapist_id INT DEFAULT NULL, DROP rights');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C143E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('CREATE INDEX IDX_64C19C143E8B094 ON category (therapist_id)');
        $this->addSql('ALTER TABLE pictogram ADD therapist_id INT DEFAULT NULL, DROP rights');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15F43E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('CREATE INDEX IDX_56E0A15F43E8B094 ON pictogram (therapist_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C143E8B094');
        $this->addSql('DROP INDEX IDX_64C19C143E8B094 ON category');
        $this->addSql('ALTER TABLE category ADD rights VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP therapist_id');
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15F43E8B094');
        $this->addSql('DROP INDEX IDX_56E0A15F43E8B094 ON pictogram');
        $this->addSql('ALTER TABLE pictogram ADD rights VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP therapist_id');
    }
}
