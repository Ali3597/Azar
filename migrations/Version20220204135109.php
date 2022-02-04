<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204135109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD views INT DEFAULT NULL');
        $this->addSql('ALTER TABLE view_counter DROP FOREIGN KEY FK_E87F8182E41DC9B2');
        $this->addSql('ALTER TABLE view_counter ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F81827294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F8182E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id)');
        $this->addSql('CREATE INDEX IDX_E87F81827294869C ON view_counter (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP views');
        $this->addSql('ALTER TABLE view_counter DROP FOREIGN KEY FK_E87F81827294869C');
        $this->addSql('ALTER TABLE view_counter DROP FOREIGN KEY FK_E87F8182E41DC9B2');
        $this->addSql('DROP INDEX IDX_E87F81827294869C ON view_counter');
        $this->addSql('ALTER TABLE view_counter DROP article_id');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F8182E41DC9B2 FOREIGN KEY (design_id) REFERENCES produit (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
