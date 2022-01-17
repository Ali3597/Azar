<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117125708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66EE45BDBF ON article (picture_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD4A76ED395 ON command (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A6F91CE5E237E06 ON marque (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A6F91CE989D9B62 ON marque (slug)');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F897294869C');
        $this->addSql('DROP INDEX IDX_16DB4F897294869C ON picture');
        $this->addSql('ALTER TABLE picture DROP article_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66EE45BDBF');
        $this->addSql('DROP INDEX UNIQ_23A0E66EE45BDBF ON article');
        $this->addSql('ALTER TABLE article DROP picture_id');
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
        $this->addSql('DROP INDEX UNIQ_64C19C1989D9B62 ON category');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4A76ED395');
        $this->addSql('DROP INDEX IDX_8ECAEAD4A76ED395 ON command');
        $this->addSql('DROP INDEX UNIQ_5A6F91CE5E237E06 ON marque');
        $this->addSql('DROP INDEX UNIQ_5A6F91CE989D9B62 ON marque');
        $this->addSql('ALTER TABLE picture ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F897294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_16DB4F897294869C ON picture (article_id)');
    }
}
