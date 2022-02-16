<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215025833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advice (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, picture_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, views INT NOT NULL, published TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_23A0E66EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, position INT NOT NULL, slide_to_scroll INT DEFAULT NULL, slide_visible INT DEFAULT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_article (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, UNIQUE INDEX UNIQ_D26E45D11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_article_article (bande_article_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_66DBA992EA3ACBCB (bande_article_id), INDEX IDX_66DBA9927294869C (article_id), PRIMARY KEY(bande_article_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, UNIQUE INDEX UNIQ_B748EC0F11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category_category (bande_category_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5361BB8DE7D1F7F8 (bande_category_id), INDEX IDX_5361BB8D12469DE2 (category_id), PRIMARY KEY(bande_category_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category_title (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, UNIQUE INDEX UNIQ_23CD94BB11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_category_title_category (bande_category_title_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_658531395FB225F1 (bande_category_title_id), INDEX IDX_6585313912469DE2 (category_id), PRIMARY KEY(bande_category_title_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_marque (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, UNIQUE INDEX UNIQ_467C9E8711999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_marque_marque (bande_marque_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_4BDCDF2D344A52F0 (bande_marque_id), INDEX IDX_4BDCDF2D4827B9B2 (marque_id), PRIMARY KEY(bande_marque_id, marque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_product (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, UNIQUE INDEX UNIQ_DC56EE9611999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_product_produit (bande_product_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_714F14D4DD2A2B0D (bande_product_id), INDEX IDX_714F14D4F347EFB (produit_id), PRIMARY KEY(bande_product_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_promo (id INT AUTO_INCREMENT NOT NULL, bande_id INT NOT NULL, UNIQUE INDEX UNIQ_CF7DB1AA11999B4A (bande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_promo_promo (bande_promo_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_ACADCC7761C48F31 (bande_promo_id), INDEX IDX_ACADCC77D0C07AFF (promo_id), PRIMARY KEY(bande_promo_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_parent_id INT DEFAULT NULL, picture_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), INDEX IDX_64C19C1B51A1840 (category_parent_id), UNIQUE INDEX UNIQ_64C19C1EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comand_products (id INT AUTO_INCREMENT NOT NULL, products_id INT NOT NULL, commands_id INT NOT NULL, number INT NOT NULL, INDEX IDX_52C9F456C8A81A9 (products_id), INDEX IDX_52C9F45F7982617 (commands_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', treated TINYINT(1) NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_8ECAEAD4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE design (id INT AUTO_INCREMENT NOT NULL, logo_id INT NOT NULL, about_us_picture_id INT NOT NULL, marque_picture_id INT NOT NULL, icon_id INT NOT NULL, primary_color VARCHAR(255) NOT NULL, sencondary_color VARCHAR(255) NOT NULL, header_title VARCHAR(255) NOT NULL, header_sub_title VARCHAR(255) NOT NULL, bande_title VARCHAR(255) NOT NULL, bande_left VARCHAR(255) NOT NULL, bande_center VARCHAR(255) NOT NULL, bande_right VARCHAR(255) NOT NULL, bande_title_left VARCHAR(255) NOT NULL, bande_title_center VARCHAR(255) NOT NULL, bande_title_right VARCHAR(255) NOT NULL, position INT DEFAULT NULL, color_bande VARCHAR(255) NOT NULL, views INT NOT NULL, about_us_title VARCHAR(255) NOT NULL, about_us_content LONGTEXT NOT NULL, about_us_picture_title VARCHAR(255) NOT NULL, about_us_picture_sub_title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CD4F5A30F98F144A (logo_id), UNIQUE INDEX UNIQ_CD4F5A307B18DA10 (about_us_picture_id), UNIQUE INDEX UNIQ_CD4F5A301784081D (marque_picture_id), UNIQUE INDEX UNIQ_CD4F5A3054B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_product (id INT AUTO_INCREMENT NOT NULL, description_id INT DEFAULT NULL, advice_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_F05D9A0D9F966B (description_id), INDEX IDX_F05D9A012998205 (advice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, picture_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5A6F91CE5E237E06 (name), UNIQUE INDEX UNIQ_5A6F91CE989D9B62 (slug), UNIQUE INDEX UNIQ_5A6F91CEEE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_16DB4F89F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, marque_id INT DEFAULT NULL, advices_id INT DEFAULT NULL, description_list_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, stock INT NOT NULL, unite VARCHAR(255) NOT NULL, afficher TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, views INT NOT NULL, INDEX IDX_29A5EC2712469DE2 (category_id), INDEX IDX_29A5EC274827B9B2 (marque_id), UNIQUE INDEX UNIQ_29A5EC279709D028 (advices_id), UNIQUE INDEX UNIQ_29A5EC27DE830336 (description_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, picture_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B0139AFBEE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, expired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B9983CE5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stat_view (id INT AUTO_INCREMENT NOT NULL, day DATE NOT NULL, view INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, telephone VARCHAR(50) NOT NULL, addresse VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_produit (user_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_71A8F22DA76ED395 (user_id), INDEX IDX_71A8F22DF347EFB (produit_id), PRIMARY KEY(user_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_counter (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, design_id INT DEFAULT NULL, article_id INT DEFAULT NULL, ip VARCHAR(255) NOT NULL, view_date DATETIME NOT NULL, INDEX IDX_E87F81824584665A (product_id), INDEX IDX_E87F8182E41DC9B2 (design_id), INDEX IDX_E87F81827294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
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
        $this->addSql('ALTER TABLE bande_promo_promo ADD CONSTRAINT FK_ACADCC7761C48F31 FOREIGN KEY (bande_promo_id) REFERENCES bande_promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_promo_promo ADD CONSTRAINT FK_ACADCC77D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B51A1840 FOREIGN KEY (category_parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE comand_products ADD CONSTRAINT FK_52C9F456C8A81A9 FOREIGN KEY (products_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE comand_products ADD CONSTRAINT FK_52C9F45F7982617 FOREIGN KEY (commands_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE design ADD CONSTRAINT FK_CD4F5A30F98F144A FOREIGN KEY (logo_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE design ADD CONSTRAINT FK_CD4F5A307B18DA10 FOREIGN KEY (about_us_picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE design ADD CONSTRAINT FK_CD4F5A301784081D FOREIGN KEY (marque_picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE design ADD CONSTRAINT FK_CD4F5A3054B9D732 FOREIGN KEY (icon_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE list_product ADD CONSTRAINT FK_F05D9A0D9F966B FOREIGN KEY (description_id) REFERENCES description (id)');
        $this->addSql('ALTER TABLE list_product ADD CONSTRAINT FK_F05D9A012998205 FOREIGN KEY (advice_id) REFERENCES advice (id)');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CEEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC279709D028 FOREIGN KEY (advices_id) REFERENCES advice (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27DE830336 FOREIGN KEY (description_list_id) REFERENCES description (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE reset_password ADD CONSTRAINT FK_B9983CE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_produit ADD CONSTRAINT FK_71A8F22DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_produit ADD CONSTRAINT FK_71A8F22DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F81824584665A FOREIGN KEY (product_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F8182E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id)');
        $this->addSql('ALTER TABLE view_counter ADD CONSTRAINT FK_E87F81827294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_product DROP FOREIGN KEY FK_F05D9A012998205');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC279709D028');
        $this->addSql('ALTER TABLE bande_article_article DROP FOREIGN KEY FK_66DBA9927294869C');
        $this->addSql('ALTER TABLE view_counter DROP FOREIGN KEY FK_E87F81827294869C');
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
        $this->addSql('ALTER TABLE bande_promo_promo DROP FOREIGN KEY FK_ACADCC7761C48F31');
        $this->addSql('ALTER TABLE bande_category_category DROP FOREIGN KEY FK_5361BB8D12469DE2');
        $this->addSql('ALTER TABLE bande_category_title_category DROP FOREIGN KEY FK_6585313912469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B51A1840');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2712469DE2');
        $this->addSql('ALTER TABLE comand_products DROP FOREIGN KEY FK_52C9F45F7982617');
        $this->addSql('ALTER TABLE list_product DROP FOREIGN KEY FK_F05D9A0D9F966B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27DE830336');
        $this->addSql('ALTER TABLE view_counter DROP FOREIGN KEY FK_E87F8182E41DC9B2');
        $this->addSql('ALTER TABLE bande_marque_marque DROP FOREIGN KEY FK_4BDCDF2D4827B9B2');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC274827B9B2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66EE45BDBF');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1EE45BDBF');
        $this->addSql('ALTER TABLE design DROP FOREIGN KEY FK_CD4F5A30F98F144A');
        $this->addSql('ALTER TABLE design DROP FOREIGN KEY FK_CD4F5A307B18DA10');
        $this->addSql('ALTER TABLE design DROP FOREIGN KEY FK_CD4F5A301784081D');
        $this->addSql('ALTER TABLE design DROP FOREIGN KEY FK_CD4F5A3054B9D732');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CEEE45BDBF');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBEE45BDBF');
        $this->addSql('ALTER TABLE bande_product_produit DROP FOREIGN KEY FK_714F14D4F347EFB');
        $this->addSql('ALTER TABLE comand_products DROP FOREIGN KEY FK_52C9F456C8A81A9');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89F347EFB');
        $this->addSql('ALTER TABLE user_produit DROP FOREIGN KEY FK_71A8F22DF347EFB');
        $this->addSql('ALTER TABLE view_counter DROP FOREIGN KEY FK_E87F81824584665A');
        $this->addSql('ALTER TABLE bande_promo_promo DROP FOREIGN KEY FK_ACADCC77D0C07AFF');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4A76ED395');
        $this->addSql('ALTER TABLE reset_password DROP FOREIGN KEY FK_B9983CE5A76ED395');
        $this->addSql('ALTER TABLE user_produit DROP FOREIGN KEY FK_71A8F22DA76ED395');
        $this->addSql('DROP TABLE advice');
        $this->addSql('DROP TABLE article');
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
        $this->addSql('DROP TABLE bande_promo_promo');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comand_products');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP TABLE design');
        $this->addSql('DROP TABLE list_product');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE reset_password');
        $this->addSql('DROP TABLE stat_view');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_produit');
        $this->addSql('DROP TABLE view_counter');
    }
}
