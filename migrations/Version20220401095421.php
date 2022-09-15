<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220401095421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictogram ADD prem_pers_sing_futur VARCHAR(50) DEFAULT NULL, ADD deux_pers_sing_futur VARCHAR(50) DEFAULT NULL, ADD trois_pers_sing_futur VARCHAR(50) DEFAULT NULL, ADD prem_pers_plur_futur VARCHAR(50) DEFAULT NULL, ADD deux_pers_plur_futur VARCHAR(50) DEFAULT NULL, ADD trois_pers_plur_futur VARCHAR(50) DEFAULT NULL, ADD prem_pers_sing_passe VARCHAR(50) DEFAULT NULL, ADD deux_pers_sing_passe VARCHAR(50) DEFAULT NULL, ADD trois_pers_sing_passe VARCHAR(50) DEFAULT NULL, ADD prem_pers_plur_passe VARCHAR(50) DEFAULT NULL, ADD deux_pers_plur_passe VARCHAR(50) DEFAULT NULL, ADD trois_pers_plur_passe VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictogram DROP prem_pers_sing_futur, DROP deux_pers_sing_futur, DROP trois_pers_sing_futur, DROP prem_pers_plur_futur, DROP deux_pers_plur_futur, DROP trois_pers_plur_futur, DROP prem_pers_sing_passe, DROP deux_pers_sing_passe, DROP trois_pers_sing_passe, DROP prem_pers_plur_passe, DROP deux_pers_plur_passe, DROP trois_pers_plur_passe');
    }
}
