<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312121214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictogram ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_56E0A15F12469DE2 ON pictogram (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15F12469DE2');
        $this->addSql('DROP INDEX IDX_56E0A15F12469DE2 ON pictogram');
        $this->addSql('ALTER TABLE pictogram DROP category_id');
    }
}
