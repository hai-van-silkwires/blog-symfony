<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190719110746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog CHANGE content content VARCHAR(255) NOT NULL, CHANGE feature_image feature_image VARCHAR(255) NOT NULL, CHANGE status status TINYINT(1) NOT NULL, CHANGE short_description short_description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD salt VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE status status SMALLINT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog CHANGE content content TEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE feature_image feature_image VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE short_description short_description VARCHAR(500) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user DROP salt, CHANGE roles roles JSON DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'0: inactive, 1:active, 2:delete\'');
    }
}
