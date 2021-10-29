<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211028155809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bande (id INT AUTO_INCREMENT NOT NULL, design_id INT NOT NULL, type VARCHAR(255) NOT NULL, position INT NOT NULL, slide_to_scroll INT DEFAULT NULL, slide_visible INT DEFAULT NULL, loopable TINYINT(1) DEFAULT NULL, INDEX IDX_D84A9E08E41DC9B2 (design_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_article (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D26E45D11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_article_article (bande_article_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_66DBA992EA3ACBCB (bande_article_id), INDEX IDX_66DBA9927294869C (article_id), PRIMARY KEY(bande_article_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B748EC0F11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category_category (bande_category_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5361BB8DE7D1F7F8 (bande_category_id), INDEX IDX_5361BB8D12469DE2 (category_id), PRIMARY KEY(bande_category_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category_title (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, limit_sub INT NOT NULL, UNIQUE INDEX UNIQ_23CD94BB11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category_title_category (bande_category_title_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_658531395FB225F1 (bande_category_title_id), INDEX IDX_6585313912469DE2 (category_id), PRIMARY KEY(bande_category_title_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_marque (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_467C9E8711999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_marque_marque (bande_marque_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_4BDCDF2D344A52F0 (bande_marque_id), INDEX IDX_4BDCDF2D4827B9B2 (marque_id), PRIMARY KEY(bande_marque_id, marque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_product (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_DC56EE9611999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_product_produit (bande_product_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_714F14D4DD2A2B0D (bande_product_id), INDEX IDX_714F14D4F347EFB (produit_id), PRIMARY KEY(bande_product_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_promo (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, UNIQUE INDEX UNIQ_CF7DB1AA11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bande ADD CONSTRAINT FK_D84A9E08E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id)');
        $this->addSql('ALTER TABLE bande_article ADD CONSTRAINT FK_D26E45D11999B4A FOREIGN KEY (bande_id) REFERENCES bande (id)');
        $this->addSql('ALTER TABLE bande_article_article ADD CONSTRAINT FK_66DBA992EA3ACBCB FOREIGN KEY (bande_article_id) REFERENCES bande_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_article_article ADD CONSTRAINT FK_66DBA9927294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_category ADD CONSTRAINT FK_B748EC0F11999B4A FOREIGN KEY (bande_id) REFERENCES bande (id)');
        $this->addSql('ALTER TABLE bande_category_category ADD CONSTRAINT FK_5361BB8DE7D1F7F8 FOREIGN KEY (bande_category_id) REFERENCES bande_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_category_category ADD CONSTRAINT FK_5361BB8D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_category_title ADD CONSTRAINT FK_23CD94BB11999B4A FOREIGN KEY (bande_id) REFERENCES bande (id)');
        $this->addSql('ALTER TABLE bande_category_title_category ADD CONSTRAINT FK_658531395FB225F1 FOREIGN KEY (bande_category_title_id) REFERENCES bande_category_title (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_category_title_category ADD CONSTRAINT FK_6585313912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_marque ADD CONSTRAINT FK_467C9E8711999B4A FOREIGN KEY (bande_id) REFERENCES bande (id)');
        $this->addSql('ALTER TABLE bande_marque_marque ADD CONSTRAINT FK_4BDCDF2D344A52F0 FOREIGN KEY (bande_marque_id) REFERENCES bande_marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_marque_marque ADD CONSTRAINT FK_4BDCDF2D4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_product ADD CONSTRAINT FK_DC56EE9611999B4A FOREIGN KEY (bande_id) REFERENCES bande (id)');
        $this->addSql('ALTER TABLE bande_product_produit ADD CONSTRAINT FK_714F14D4DD2A2B0D FOREIGN KEY (bande_product_id) REFERENCES bande_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_product_produit ADD CONSTRAINT FK_714F14D4F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_promo ADD CONSTRAINT FK_CF7DB1AA11999B4A FOREIGN KEY (bande_id) REFERENCES bande (id)');
        $this->addSql('ALTER TABLE picture ADD bande_promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8961C48F31 FOREIGN KEY (bande_promo_id) REFERENCES bande_promo (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8961C48F31 ON picture (bande_promo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande_article DROP FOREIGN KEY FK_D26E45D11999B4A');
        $this->addSql('ALTER TABLE bande_category DROP FOREIGN KEY FK_B748EC0F11999B4A');
        $this->addSql('ALTER TABLE bande_category_title DROP FOREIGN KEY FK_23CD94BB11999B4A');
        $this->addSql('ALTER TABLE bande_marque DROP FOREIGN KEY FK_467C9E8711999B4A');
        $this->addSql('ALTER TABLE bande_product DROP FOREIGN KEY FK_DC56EE9611999B4A');
        $this->addSql('ALTER TABLE bande_promo DROP FOREIGN KEY FK_CF7DB1AA11999B4A');
        $this->addSql('ALTER TABLE bande_article_article DROP FOREIGN KEY FK_66DBA992EA3ACBCB');
        $this->addSql('ALTER TABLE bande_category_category DROP FOREIGN KEY FK_5361BB8DE7D1F7F8');
        $this->addSql('ALTER TABLE bande_category_title_category DROP FOREIGN KEY FK_658531395FB225F1');
        $this->addSql('ALTER TABLE bande_marque_marque DROP FOREIGN KEY FK_4BDCDF2D344A52F0');
        $this->addSql('ALTER TABLE bande_product_produit DROP FOREIGN KEY FK_714F14D4DD2A2B0D');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8961C48F31');
        $this->addSql('DROP TABLE bande');
        $this->addSql('DROP TABLE bande_article');
        $this->addSql('DROP TABLE bande_article_article');
        $this->addSql('DROP TABLE bande_category');
        $this->addSql('DROP TABLE bande_category_category');
        $this->addSql('DROP TABLE bande_category_title');
        $this->addSql('DROP TABLE bande_category_title_category');
        $this->addSql('DROP TABLE bande_marque');
        $this->addSql('DROP TABLE bande_marque_marque');
        $this->addSql('DROP TABLE bande_product');
        $this->addSql('DROP TABLE bande_product_produit');
        $this->addSql('DROP TABLE bande_promo');
        $this->addSql('DROP INDEX IDX_16DB4F8961C48F31 ON picture');
        $this->addSql('ALTER TABLE picture DROP bande_promo_id');
    }
}
