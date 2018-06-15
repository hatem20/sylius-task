<?php declare(strict_types=1);

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180615205223 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_stock ADD stock_room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3C4DB16030 FOREIGN KEY (stock_room_id) REFERENCES stock_room (id)');
        $this->addSql('CREATE INDEX IDX_EA6A2D3C4DB16030 ON product_stock (stock_room_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3C4DB16030');
        $this->addSql('DROP INDEX IDX_EA6A2D3C4DB16030 ON product_stock');
        $this->addSql('ALTER TABLE product_stock DROP stock_room_id');
    }
}
