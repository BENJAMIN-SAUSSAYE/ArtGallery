<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230718104829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album CHANGE is_private is_private TINYINT(1) DEFAULT true NOT NULL, CHANGE is_main_album is_main_album TINYINT(1) DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE picture ADD album_id INT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F891137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F891137ABCF ON picture (album_id)');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) DEFAULT false NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F891137ABCF');
        $this->addSql('DROP INDEX IDX_16DB4F891137ABCF ON picture');
        $this->addSql('ALTER TABLE picture DROP album_id');
        $this->addSql('ALTER TABLE album CHANGE is_private is_private TINYINT(1) DEFAULT 1 NOT NULL, CHANGE is_main_album is_main_album TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
