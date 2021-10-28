<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027171124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marque CHANGE picture_id picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CEEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A6F91CEEE45BDBF ON marque (picture_id)');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F894827B9B2');
        $this->addSql('DROP INDEX IDX_16DB4F894827B9B2 ON picture');
        $this->addSql('ALTER TABLE picture DROP marque_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CEEE45BDBF');
        $this->addSql('DROP INDEX UNIQ_5A6F91CEEE45BDBF ON marque');
        $this->addSql('ALTER TABLE marque CHANGE picture_id picture_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD marque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F894827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_16DB4F894827B9B2 ON picture (marque_id)');
    }
}
