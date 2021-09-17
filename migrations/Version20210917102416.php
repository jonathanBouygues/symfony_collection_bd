<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210917102416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, created_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_bande_dessinee (author_id INT NOT NULL, bande_dessinee_id INT NOT NULL, INDEX IDX_95709518F675F31B (author_id), INDEX IDX_957095184AD81C29 (bande_dessinee_id), PRIMARY KEY(author_id, bande_dessinee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE author_bande_dessinee ADD CONSTRAINT FK_95709518F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_bande_dessinee ADD CONSTRAINT FK_957095184AD81C29 FOREIGN KEY (bande_dessinee_id) REFERENCES bande_dessinee (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author_bande_dessinee DROP FOREIGN KEY FK_95709518F675F31B');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_bande_dessinee');
    }
}
