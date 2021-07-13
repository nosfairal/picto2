<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310172051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, rights VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, rights VARCHAR(255) NOT NULL, genre VARCHAR(255) DEFAULT NULL, pluriel VARCHAR(255) DEFAULT NULL, prem_pers_sing VARCHAR(50) DEFAULT NULL, deux_pers_sing VARCHAR(50) DEFAULT NULL, trois_pers_sing VARCHAR(50) DEFAULT NULL, prem_pers_plur VARCHAR(50) DEFAULT NULL, deux_pers_plur VARCHAR(50) DEFAULT NULL, trois_pers_plur VARCHAR(50) DEFAULT NULL, participe VARCHAR(255) DEFAULT NULL, masculin_sing VARCHAR(50) DEFAULT NULL, masculin_plur VARCHAR(50) DEFAULT NULL, feminin_sing VARCHAR(50) DEFAULT NULL, feminin_plur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE pictogram');
    }
}
