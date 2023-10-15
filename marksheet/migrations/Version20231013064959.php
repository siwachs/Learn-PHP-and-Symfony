<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013064959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marks (id INT AUTO_INCREMENT NOT NULL, roll_number INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, total_marks INT NOT NULL, passing_marks INT NOT NULL, obtained_marks INT NOT NULL, grade VARCHAR(1) NOT NULL, INDEX IDX_3C6AFA5322F9E5CE (roll_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (roll_number INT NOT NULL, name VARCHAR(255) NOT NULL, class VARCHAR(2) NOT NULL, session VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, father_name VARCHAR(255) NOT NULL, PRIMARY KEY(roll_number)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marks ADD CONSTRAINT FK_3C6AFA5322F9E5CE FOREIGN KEY (roll_number) REFERENCES students (roll_number)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marks DROP FOREIGN KEY FK_3C6AFA5322F9E5CE');
        $this->addSql('DROP TABLE marks');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
