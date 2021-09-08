<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908152919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary CHANGE user_id user_id INT NOT NULL, CHANGE trick_id trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture CHANGE tricks_id tricks_id INT NOT NULL');
        $this->addSql('ALTER TABLE video CHANGE trick_id trick_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary CHANGE user_id user_id INT DEFAULT NULL, CHANGE trick_id trick_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture CHANGE tricks_id tricks_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video CHANGE trick_id trick_id INT DEFAULT NULL');
    }
}
