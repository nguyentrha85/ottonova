<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181204141629 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dob DATE NOT NULL, start_date DATE NOT NULL, special_contract SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql("INSERT INTO `employee` (`id`, `name`, `dob`, `start_date`, `special_contract`) VALUES (1, 'Hans Müller', '1950-12-30', '2001-01-01', NULL), (2, 'Angelika Fringe', '1966-06-09', '2001-01-15', NULL), (3, 'Peter Klever', '1991-07-12', '2016-05-15', 27);");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE employee');
    }
}
