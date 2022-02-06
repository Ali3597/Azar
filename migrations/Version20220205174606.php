<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220205174606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE view_counter (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, design_id INT DEFAULT NULL, article_id INT DEFAULT NULL, ip VARCHAR(255) NOT NULL, view_date DATETIME NOT NULL, INDEX IDX_E87F81824584665A (product_id), INDEX IDX_E87F8182E41DC9B2 (design_id), INDEX IDX_E87F81827294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F81824584665A FOREIGN KEY (product_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F8182E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id)');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F81827294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE view_counter');
    }
}
