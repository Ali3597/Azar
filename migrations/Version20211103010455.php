<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103010455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande DROP FOREIGN KEY FK_D84A9E08E41DC9B2');
        $this->addSql('DROP INDEX IDX_D84A9E08E41DC9B2 ON bande');
        $this->addSql('ALTER TABLE bande ADD title VARCHAR(255) NOT NULL, ADD subtitle VARCHAR(255) DEFAULT NULL, DROP design_id');
        $this->addSql('ALTER TABLE bande_article DROP title, DROP subtitle');
        $this->addSql('ALTER TABLE bande_category DROP title, DROP subtitle');
        $this->addSql('ALTER TABLE bande_marque DROP title, DROP subtitle');
        $this->addSql('ALTER TABLE bande_product DROP title, DROP subtitle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande ADD design_id INT NOT NULL, DROP title, DROP subtitle');
        $this->addSql('ALTER TABLE bande ADD CONSTRAINT FK_D84A9E08E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D84A9E08E41DC9B2 ON bande (design_id)');
        $this->addSql('ALTER TABLE bande_article ADD title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD subtitle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE bande_category ADD title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD subtitle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE bande_marque ADD title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD subtitle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE bande_product ADD title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD subtitle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
