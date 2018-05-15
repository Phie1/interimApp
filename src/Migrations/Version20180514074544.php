<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180514074544 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, interim_id INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, status enum(\'waiting\', \'progress\', \'finished\'), INDEX IDX_E98F285929C96BD8 (interim_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interim (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, surname VARCHAR(32) NOT NULL, mail VARCHAR(255) NOT NULL, zip_code VARCHAR(5) NOT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, interim_id INT NOT NULL, contract_id INT NOT NULL, rating INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_9067F23C29C96BD8 (interim_id), UNIQUE INDEX UNIQ_9067F23C2576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285929C96BD8 FOREIGN KEY (interim_id) REFERENCES interim (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C29C96BD8 FOREIGN KEY (interim_id) REFERENCES interim (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C2576E0FD');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285929C96BD8');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C29C96BD8');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE interim');
        $this->addSql('DROP TABLE mission');
    }
}
