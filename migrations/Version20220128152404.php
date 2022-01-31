<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220128152404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advice (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_product (id INT AUTO_INCREMENT NOT NULL, description_id INT DEFAULT NULL, advice_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_F05D9A0D9F966B (description_id), INDEX IDX_F05D9A012998205 (advice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_product ADD CONSTRAINT FK_F05D9A0D9F966B FOREIGN KEY (description_id) REFERENCES description (id)');
        $this->addSql('ALTER TABLE list_product ADD CONSTRAINT FK_F05D9A012998205 FOREIGN KEY (advice_id) REFERENCES advice (id)');
        $this->addSql('ALTER TABLE produit ADD advices_id INT DEFAULT NULL, ADD description_list_id INT DEFAULT NULL, DROP description');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC279709D028 FOREIGN KEY (advices_id) REFERENCES advice (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27DE830336 FOREIGN KEY (description_list_id) REFERENCES description (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC279709D028 ON produit (advices_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC27DE830336 ON produit (description_list_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_product DROP FOREIGN KEY FK_F05D9A012998205');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC279709D028');
        $this->addSql('ALTER TABLE list_product DROP FOREIGN KEY FK_F05D9A0D9F966B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27DE830336');
        $this->addSql('DROP TABLE advice');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP TABLE list_product');
        $this->addSql('DROP INDEX UNIQ_29A5EC279709D028 ON produit');
        $this->addSql('DROP INDEX UNIQ_29A5EC27DE830336 ON produit');
        $this->addSql('ALTER TABLE produit ADD description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP advices_id, DROP description_list_id');
    }
}
