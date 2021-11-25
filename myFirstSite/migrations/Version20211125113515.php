<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125113515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_place (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place ADD category_place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDBADC2662 FOREIGN KEY (category_place_id) REFERENCES category_place (id)');
        $this->addSql('CREATE INDEX IDX_741D53CDBADC2662 ON place (category_place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDBADC2662');
        $this->addSql('DROP TABLE category_place');
        $this->addSql('DROP INDEX IDX_741D53CDBADC2662 ON place');
        $this->addSql('ALTER TABLE place DROP category_place_id');
    }
}
