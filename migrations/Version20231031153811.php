<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231031153811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, account_status VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81589BE29 FOREIGN KEY (address_category_id) REFERENCES address_category (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8152D06999 FOREIGN KEY (user_address_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B75CB41B92 FOREIGN KEY (cart_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3DA5256D FOREIGN KEY (image_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE line_cart ADD CONSTRAINT FK_80EE7B6E1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE line_cart ADD CONSTRAINT FK_80EE7B6E8B0B8AD0 FOREIGN KEY (line_cart_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE line_product ADD CONSTRAINT FK_66EE85CA185F1B3D FOREIGN KEY (line_product_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE line_product ADD CONSTRAINT FK_66EE85CA9CA26EF2 FOREIGN KEY (product_line_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E443B061 FOREIGN KEY (address2_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939851147ADE FOREIGN KEY (order_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD14959723 FOREIGN KEY (product_type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE returned_product ADD CONSTRAINT FK_AF6E52FE34DAD0BE FOREIGN KEY (order_returned_product_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE returned_product ADD CONSTRAINT FK_AF6E52FE2A482DBB FOREIGN KEY (product_returned_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6508E2016 FOREIGN KEY (product_review_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C63C806762 FOREIGN KEY (review_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F8152D06999');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B75CB41B92');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939851147ADE');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C63C806762');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81589BE29');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3DA5256D');
        $this->addSql('ALTER TABLE line_cart DROP FOREIGN KEY FK_80EE7B6E1AD5CDBF');
        $this->addSql('ALTER TABLE line_cart DROP FOREIGN KEY FK_80EE7B6E8B0B8AD0');
        $this->addSql('ALTER TABLE line_product DROP FOREIGN KEY FK_66EE85CA185F1B3D');
        $this->addSql('ALTER TABLE line_product DROP FOREIGN KEY FK_66EE85CA9CA26EF2');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F5B7AF75');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E443B061');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398EBF23851');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C6BDFEB');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD14959723');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39C4584665A');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39CBAD26311');
        $this->addSql('ALTER TABLE returned_product DROP FOREIGN KEY FK_AF6E52FE34DAD0BE');
        $this->addSql('ALTER TABLE returned_product DROP FOREIGN KEY FK_AF6E52FE2A482DBB');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6508E2016');
    }
}
