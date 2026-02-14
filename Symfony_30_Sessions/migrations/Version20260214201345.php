<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260214201345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_post ADD last_edit_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE app_post ADD last_editor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_post ADD CONSTRAINT FK_5FA4492D7E5A734A FOREIGN KEY (last_editor_id) REFERENCES app_user (id)');
        $this->addSql('CREATE INDEX IDX_5FA4492D7E5A734A ON app_post (last_editor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_post DROP CONSTRAINT FK_5FA4492D7E5A734A');
        $this->addSql('DROP INDEX IDX_5FA4492D7E5A734A');
        $this->addSql('ALTER TABLE app_post DROP last_edit_date');
        $this->addSql('ALTER TABLE app_post DROP last_editor_id');
    }
}
