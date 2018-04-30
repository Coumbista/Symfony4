<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180424190655 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation ADD client_id INT DEFAULT NULL, ADD bien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('CREATE INDEX IDX_42C84955BD95B80F ON reservation (bien_id)');
        $this->addSql('ALTER TABLE image ADD bien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FBD95B80F ON image (bien_id)');
        $this->addSql('ALTER TABLE bien ADD localite_id INT DEFAULT NULL, ADD typebien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC386924DD2B5 FOREIGN KEY (localite_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC386677134B4 FOREIGN KEY (typebien_id) REFERENCES typebien (id)');
        $this->addSql('CREATE INDEX IDX_45EDC386924DD2B5 ON bien (localite_id)');
        $this->addSql('CREATE INDEX IDX_45EDC386677134B4 ON bien (typebien_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC386924DD2B5');
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC386677134B4');
        $this->addSql('DROP INDEX IDX_45EDC386924DD2B5 ON bien');
        $this->addSql('DROP INDEX IDX_45EDC386677134B4 ON bien');
        $this->addSql('ALTER TABLE bien DROP localite_id, DROP typebien_id');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBD95B80F');
        $this->addSql('DROP INDEX IDX_C53D045FBD95B80F ON image');
        $this->addSql('ALTER TABLE image DROP bien_id');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BD95B80F');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955BD95B80F ON reservation');
        $this->addSql('ALTER TABLE reservation DROP client_id, DROP bien_id');
    }
}
