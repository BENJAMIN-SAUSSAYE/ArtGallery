<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720203812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_favorite_picture (picture_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_369AA33AEE45BDBF (picture_id), INDEX IDX_369AA33AA76ED395 (user_id), PRIMARY KEY(picture_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_favorite_picture ADD CONSTRAINT FK_369AA33AEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_picture ADD CONSTRAINT FK_369AA33AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_user DROP FOREIGN KEY FK_327353DCA76ED395');
        $this->addSql('ALTER TABLE picture_user DROP FOREIGN KEY FK_327353DCEE45BDBF');
        $this->addSql('DROP TABLE picture_user');
        $this->addSql('ALTER TABLE album CHANGE is_private is_private TINYINT(1) DEFAULT true NOT NULL, CHANGE is_main_album is_main_album TINYINT(1) DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) DEFAULT false NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_user (picture_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_327353DCA76ED395 (user_id), INDEX IDX_327353DCEE45BDBF (picture_id), PRIMARY KEY(picture_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture_user ADD CONSTRAINT FK_327353DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_user ADD CONSTRAINT FK_327353DCEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_picture DROP FOREIGN KEY FK_369AA33AEE45BDBF');
        $this->addSql('ALTER TABLE user_favorite_picture DROP FOREIGN KEY FK_369AA33AA76ED395');
        $this->addSql('DROP TABLE user_favorite_picture');
        $this->addSql('ALTER TABLE album CHANGE is_private is_private TINYINT(1) DEFAULT 1 NOT NULL, CHANGE is_main_album is_main_album TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
