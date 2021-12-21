<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211116135150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F893B153154');
        $this->addSql('ALTER TABLE picture CHANGE tricks_id tricks_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F893B153154 FOREIGN KEY (tricks_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CB281BE2E');
        $this->addSql('ALTER TABLE video CHANGE trick_id trick_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F893B153154');
        $this->addSql('ALTER TABLE picture CHANGE tricks_id tricks_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F893B153154 FOREIGN KEY (tricks_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CB281BE2E');
        $this->addSql('ALTER TABLE video CHANGE trick_id trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
    }
}
