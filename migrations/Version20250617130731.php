<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250617130731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE `user` (
              `id` int NOT NULL AUTO_INCREMENT,
              `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
              `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `roles` json NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `user`;');
    }
}
