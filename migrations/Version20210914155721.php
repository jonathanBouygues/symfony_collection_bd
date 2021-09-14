<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914155721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande_dessinee ADD editor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bande_dessinee ADD CONSTRAINT FK_4BF856426995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id)');
        $this->addSql('CREATE INDEX IDX_4BF856426995AC4C ON bande_dessinee (editor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande_dessinee DROP FOREIGN KEY FK_4BF856426995AC4C');
        $this->addSql('DROP INDEX IDX_4BF856426995AC4C ON bande_dessinee');
        $this->addSql('ALTER TABLE bande_dessinee DROP editor_id');
    }
}
