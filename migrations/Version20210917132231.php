<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210917132231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bande_dessinee_author (bande_dessinee_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_798E74514AD81C29 (bande_dessinee_id), INDEX IDX_798E7451F675F31B (author_id), PRIMARY KEY(bande_dessinee_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bande_dessinee_author ADD CONSTRAINT FK_798E74514AD81C29 FOREIGN KEY (bande_dessinee_id) REFERENCES bande_dessinee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_dessinee_author ADD CONSTRAINT FK_798E7451F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bande_dessinee_author');
    }
}
