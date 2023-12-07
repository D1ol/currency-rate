<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231207164637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rate table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, currency_id INT NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', mid DOUBLE PRECISION NOT NULL, INDEX IDX_DFEC3F3938248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F3938248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F3938248176');
        $this->addSql('DROP TABLE rate');
    }
}
