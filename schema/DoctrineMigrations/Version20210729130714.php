<?php

namespace Application\Migrations;

use Ivoz\Core\Infrastructure\Persistence\Doctrine\LoggableMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210729130714 extends LoggableMigration
{
    public function isTransactional() : bool
    {
        return false;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE CallForwardSettings ADD ddiId INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE CallForwardSettings ADD CONSTRAINT FK_E71B58A432B6E766 FOREIGN KEY (ddiId) REFERENCES DDIs (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_E71B58A432B6E766 ON CallForwardSettings (ddiId)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE CallForwardSettings DROP FOREIGN KEY FK_E71B58A432B6E766');
        $this->addSql('DROP INDEX IDX_E71B58A432B6E766 ON CallForwardSettings');
        $this->addSql('ALTER TABLE CallForwardSettings DROP ddiId');
    }
}
