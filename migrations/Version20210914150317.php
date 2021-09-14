<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914150317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE copy ADD bande_dessinee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE copy ADD CONSTRAINT FK_4DBABB824AD81C29 FOREIGN KEY (bande_dessinee_id) REFERENCES bande_dessinee (id)');
        $this->addSql('CREATE INDEX IDX_4DBABB824AD81C29 ON copy (bande_dessinee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE copy DROP FOREIGN KEY FK_4DBABB824AD81C29');
        $this->addSql('DROP INDEX IDX_4DBABB824AD81C29 ON copy');
        $this->addSql('ALTER TABLE copy DROP bande_dessinee_id');
    }
}
