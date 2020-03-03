<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303071302 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE purchase ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_6117D13B12469DE2 ON purchase (category_id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C112469DE2');
        $this->addSql('DROP INDEX IDX_64C19C112469DE2 ON category');
        $this->addSql('ALTER TABLE category CHANGE category_id household_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1E79FF843 FOREIGN KEY (household_id) REFERENCES household (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1E79FF843 ON category (household_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1E79FF843');
        $this->addSql('DROP INDEX IDX_64C19C1E79FF843 ON category');
        $this->addSql('ALTER TABLE category CHANGE household_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C112469DE2 FOREIGN KEY (category_id) REFERENCES household (id)');
        $this->addSql('CREATE INDEX IDX_64C19C112469DE2 ON category (category_id)');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B12469DE2');
        $this->addSql('DROP INDEX IDX_6117D13B12469DE2 ON purchase');
        $this->addSql('ALTER TABLE purchase DROP category_id');
    }
}
