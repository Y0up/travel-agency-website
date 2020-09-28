<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191209173159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incl (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incl_tour (incl_id INT NOT NULL, tour_id INT NOT NULL, INDEX IDX_E71676EE87DEE166 (incl_id), INDEX IDX_E71676EE15ED8D43 (tour_id), PRIMARY KEY(incl_id, tour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incl_activity (incl_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_2121657187DEE166 (incl_id), INDEX IDX_2121657181C06096 (activity_id), PRIMARY KEY(incl_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE requ (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE requ_tour (requ_id INT NOT NULL, tour_id INT NOT NULL, INDEX IDX_407168A0BFF10566 (requ_id), INDEX IDX_407168A015ED8D43 (tour_id), PRIMARY KEY(requ_id, tour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE requ_activity (requ_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_2E5C0F2EBFF10566 (requ_id), INDEX IDX_2E5C0F2E81C06096 (activity_id), PRIMARY KEY(requ_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incl_tour ADD CONSTRAINT FK_E71676EE87DEE166 FOREIGN KEY (incl_id) REFERENCES incl (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incl_tour ADD CONSTRAINT FK_E71676EE15ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incl_activity ADD CONSTRAINT FK_2121657187DEE166 FOREIGN KEY (incl_id) REFERENCES incl (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incl_activity ADD CONSTRAINT FK_2121657181C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE requ_tour ADD CONSTRAINT FK_407168A0BFF10566 FOREIGN KEY (requ_id) REFERENCES requ (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE requ_tour ADD CONSTRAINT FK_407168A015ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE requ_activity ADD CONSTRAINT FK_2E5C0F2EBFF10566 FOREIGN KEY (requ_id) REFERENCES requ (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE requ_activity ADD CONSTRAINT FK_2E5C0F2E81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incl_tour DROP FOREIGN KEY FK_E71676EE87DEE166');
        $this->addSql('ALTER TABLE incl_activity DROP FOREIGN KEY FK_2121657187DEE166');
        $this->addSql('ALTER TABLE requ_tour DROP FOREIGN KEY FK_407168A0BFF10566');
        $this->addSql('ALTER TABLE requ_activity DROP FOREIGN KEY FK_2E5C0F2EBFF10566');
        $this->addSql('DROP TABLE incl');
        $this->addSql('DROP TABLE incl_tour');
        $this->addSql('DROP TABLE incl_activity');
        $this->addSql('DROP TABLE requ');
        $this->addSql('DROP TABLE requ_tour');
        $this->addSql('DROP TABLE requ_activity');
    }
}
