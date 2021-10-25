<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211024230518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, marque_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, stock INT NOT NULL, unite VARCHAR(255) NOT NULL, afficher TINYINT(1) NOT NULL, INDEX IDX_29A5EC2712469DE2 (category_id), INDEX IDX_29A5EC274827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE picture ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89F347EFB ON picture (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89F347EFB');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP INDEX IDX_16DB4F89F347EFB ON picture');
        $this->addSql('ALTER TABLE picture DROP produit_id');
    }
}
