<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211107043129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bande_promo_promo (bande_promo_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_ACADCC7761C48F31 (bande_promo_id), INDEX IDX_ACADCC77D0C07AFF (promo_id), PRIMARY KEY(bande_promo_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, picture_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B0139AFBEE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bande_promo_promo ADD CONSTRAINT FK_ACADCC7761C48F31 FOREIGN KEY (bande_promo_id) REFERENCES bande_promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_promo_promo ADD CONSTRAINT FK_ACADCC77D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande_promo_promo DROP FOREIGN KEY FK_ACADCC77D0C07AFF');
        $this->addSql('DROP TABLE bande_promo_promo');
        $this->addSql('DROP TABLE promo');
    }
}
