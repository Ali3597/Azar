<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220205161514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE view_counter');
        $this->addSql('ALTER TABLE article DROP views');
        $this->addSql('ALTER TABLE design DROP views');
        $this->addSql('ALTER TABLE produit DROP views');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE view_counter (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, design_id INT DEFAULT NULL, article_id INT DEFAULT NULL, ip LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, view_date DATETIME NOT NULL, INDEX IDX_E87F81827294869C (article_id), INDEX IDX_E87F8182E41DC9B2 (design_id), INDEX IDX_E87F8182F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F81827294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F8182E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F8182F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE article ADD views INT DEFAULT NULL');
        $this->addSql('ALTER TABLE design ADD views INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD views INT DEFAULT NULL');
    }
}
