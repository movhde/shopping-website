<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516083911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B171EB6C');
        $this->addSql('DROP INDEX IDX_F5299398B171EB6C ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE customer_id_id customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993989395C3F3 ON `order` (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('DROP INDEX IDX_F52993989395C3F3 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE customer_id customer_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B171EB6C FOREIGN KEY (customer_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398B171EB6C ON `order` (customer_id_id)');
    }
}
