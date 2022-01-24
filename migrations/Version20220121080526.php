<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121080526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande CHANGE discr type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bande_article ADD CONSTRAINT FK_D26E45D11999B4A FOREIGN KEY (bande_id) REFERENCES bande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D26E45D11999B4A ON bande_article (bande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande CHANGE type discr VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE bande_article DROP FOREIGN KEY FK_D26E45D11999B4A');
        $this->addSql('DROP INDEX UNIQ_D26E45D11999B4A ON bande_article');
    }
}
