<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180513190653 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285929C96BD8 FOREIGN KEY (interim_id) REFERENCES interim (id)');
        $this->addSql('CREATE INDEX IDX_E98F285929C96BD8 ON contract (interim_id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C29C96BD8 FOREIGN KEY (interim_id) REFERENCES interim (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('CREATE INDEX IDX_9067F23C29C96BD8 ON mission (interim_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9067F23C2576E0FD ON mission (contract_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285929C96BD8');
        $this->addSql('DROP INDEX IDX_E98F285929C96BD8 ON contract');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C29C96BD8');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C2576E0FD');
        $this->addSql('DROP INDEX IDX_9067F23C29C96BD8 ON mission');
        $this->addSql('DROP INDEX UNIQ_9067F23C2576E0FD ON mission');
    }
}
