<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103132842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attachment (id UUID NOT NULL, user_id_id UUID NOT NULL, file_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, size BIGINT NOT NULL, upload_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_795FD9BB9D86650F ON attachment (user_id_id)');
        $this->addSql('COMMENT ON COLUMN attachment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN attachment.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN attachment.upload_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE attachment_mail_association (id UUID NOT NULL, attachment_id_id UUID DEFAULT NULL, mail_id_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1981D34C9DAC07E ON attachment_mail_association (attachment_id_id)');
        $this->addSql('CREATE INDEX IDX_1981D344B873C38 ON attachment_mail_association (mail_id_id)');
        $this->addSql('COMMENT ON COLUMN attachment_mail_association.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN attachment_mail_association.attachment_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN attachment_mail_association.mail_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE attachment_template_mail_association (id UUID NOT NULL, attachment_id_id UUID DEFAULT NULL, template_id_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_36AADFFCC9DAC07E ON attachment_template_mail_association (attachment_id_id)');
        $this->addSql('CREATE INDEX IDX_36AADFFC4C924D98 ON attachment_template_mail_association (template_id_id)');
        $this->addSql('COMMENT ON COLUMN attachment_template_mail_association.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN attachment_template_mail_association.attachment_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN attachment_template_mail_association.template_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE campaign (id UUID NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN campaign.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN campaign.start_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN campaign.end_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN campaign.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN campaign.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company (id UUID NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, sector VARCHAR(255) NOT NULL, size BIGINT NOT NULL, website VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN company.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN company.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE contact (id UUID NOT NULL, user_id_id UUID DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, marketing BOOLEAN NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_interaction TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, interaction_count BIGINT NOT NULL, comment TEXT DEFAULT NULL, source VARCHAR(255) DEFAULT NULL, language VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C62E6389D86650F ON contact (user_id_id)');
        $this->addSql('COMMENT ON COLUMN contact.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contact.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contact.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN contact.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN contact.last_interaction IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE contact_company_association (id UUID NOT NULL, contact_id_id UUID DEFAULT NULL, company_id_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B9C97A31526E8E58 ON contact_company_association (contact_id_id)');
        $this->addSql('CREATE INDEX IDX_B9C97A3138B53C32 ON contact_company_association (company_id_id)');
        $this->addSql('COMMENT ON COLUMN contact_company_association.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contact_company_association.contact_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contact_company_association.company_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE cta (id UUID NOT NULL, user_id_id UUID NOT NULL, template_id_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, content TEXT NOT NULL, destination_url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C43641579D86650F ON cta (user_id_id)');
        $this->addSql('CREATE INDEX IDX_C43641574C924D98 ON cta (template_id_id)');
        $this->addSql('COMMENT ON COLUMN cta.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta.template_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN cta.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE cta_clicks (id UUID NOT NULL, cta_id_id UUID NOT NULL, click_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, click_ip VARCHAR(255) NOT NULL, user_agent VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2CD1C405C282A29C ON cta_clicks (cta_id_id)');
        $this->addSql('COMMENT ON COLUMN cta_clicks.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta_clicks.cta_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta_clicks.click_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE cta_stats (id UUID NOT NULL, cta_id_id UUID NOT NULL, total_views BIGINT NOT NULL, total_clicks BIGINT NOT NULL, stat_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EA815B61C282A29C ON cta_stats (cta_id_id)');
        $this->addSql('COMMENT ON COLUMN cta_stats.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta_stats.cta_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta_stats.stat_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE cta_template (id UUID NOT NULL, user_id_id UUID NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, content TEXT NOT NULL, destination_url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6E78E59D86650F ON cta_template (user_id_id)');
        $this->addSql('COMMENT ON COLUMN cta_template.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta_template.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cta_template.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN cta_template.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE db_logs (id UUID NOT NULL, user_id_id UUID NOT NULL, table_name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, edit_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CC2158839D86650F ON db_logs (user_id_id)');
        $this->addSql('COMMENT ON COLUMN db_logs.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_logs.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_logs.edit_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE form (id UUID NOT NULL, user_id_id UUID NOT NULL, template_id_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, content TEXT NOT NULL, crated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5288FD4F9D86650F ON form (user_id_id)');
        $this->addSql('CREATE INDEX IDX_5288FD4F4C924D98 ON form (template_id_id)');
        $this->addSql('COMMENT ON COLUMN form.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form.template_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form.crated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN form.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE form_stats (id UUID NOT NULL, form_id_id UUID NOT NULL, total_views BIGINT NOT NULL, total_submits BIGINT NOT NULL, stat_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D400C369FC033A94 ON form_stats (form_id_id)');
        $this->addSql('COMMENT ON COLUMN form_stats.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form_stats.form_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form_stats.stat_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE form_submits (id UUID NOT NULL, form_id_id UUID NOT NULL, data TEXT NOT NULL, submit_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, submit_ip VARCHAR(255) NOT NULL, useragent VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5888EA9FC033A94 ON form_submits (form_id_id)');
        $this->addSql('COMMENT ON COLUMN form_submits.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form_submits.form_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form_submits.submit_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE form_template (id UUID NOT NULL, user_id_id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_265A9AC79D86650F ON form_template (user_id_id)');
        $this->addSql('COMMENT ON COLUMN form_template.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form_template.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN form_template.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN form_template.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE interaction (id UUID NOT NULL, contact_id_id UUID NOT NULL, user_id_id UUID NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, outcome VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_378DFDA7526E8E58 ON interaction (contact_id_id)');
        $this->addSql('CREATE INDEX IDX_378DFDA79D86650F ON interaction (user_id_id)');
        $this->addSql('COMMENT ON COLUMN interaction.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN interaction.contact_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN interaction.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN interaction.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE mail (id UUID NOT NULL, contact_id_id UUID DEFAULT NULL, template_id_id UUID DEFAULT NULL, user_id_id UUID NOT NULL, subject VARCHAR(255) NOT NULL, body TEXT NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sender_mail VARCHAR(255) NOT NULL, receiver VARCHAR(255) NOT NULL, read BOOLEAN NOT NULL, dead_pixel_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5126AC48526E8E58 ON mail (contact_id_id)');
        $this->addSql('CREATE INDEX IDX_5126AC484C924D98 ON mail (template_id_id)');
        $this->addSql('CREATE INDEX IDX_5126AC489D86650F ON mail (user_id_id)');
        $this->addSql('COMMENT ON COLUMN mail.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN mail.contact_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN mail.template_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN mail.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN mail.timestamp IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE mail_template (id UUID NOT NULL, user_id_id UUID NOT NULL, subject VARCHAR(255) NOT NULL, body TEXT NOT NULL, sender_mail VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4AB7DECB9D86650F ON mail_template (user_id_id)');
        $this->addSql('COMMENT ON COLUMN mail_template.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN mail_template.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE segment (id UUID NOT NULL, name VARCHAR(255) NOT NULL, criterias VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN segment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE segment_campaign_association (id UUID NOT NULL, segment_id_id UUID NOT NULL, campaign_id_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D3C1D186A411099 ON segment_campaign_association (segment_id_id)');
        $this->addSql('CREATE INDEX IDX_8D3C1D183141FA38 ON segment_campaign_association (campaign_id_id)');
        $this->addSql('COMMENT ON COLUMN segment_campaign_association.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN segment_campaign_association.segment_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN segment_campaign_association.campaign_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE segment_contact_association (id UUID NOT NULL, segment_id_id UUID NOT NULL, contact_id_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_87F6E5DF6A411099 ON segment_contact_association (segment_id_id)');
        $this->addSql('CREATE INDEX IDX_87F6E5DF526E8E58 ON segment_contact_association (contact_id_id)');
        $this->addSql('COMMENT ON COLUMN segment_contact_association.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN segment_contact_association.segment_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN segment_contact_association.contact_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE task (id UUID NOT NULL, user_id_id UUID NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, due_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB259D86650F ON task (user_id_id)');
        $this->addSql('COMMENT ON COLUMN task.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN task.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN task.due_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_action TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, jwt_token VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".last_action IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attachment_mail_association ADD CONSTRAINT FK_1981D34C9DAC07E FOREIGN KEY (attachment_id_id) REFERENCES attachment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attachment_mail_association ADD CONSTRAINT FK_1981D344B873C38 FOREIGN KEY (mail_id_id) REFERENCES mail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attachment_template_mail_association ADD CONSTRAINT FK_36AADFFCC9DAC07E FOREIGN KEY (attachment_id_id) REFERENCES attachment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attachment_template_mail_association ADD CONSTRAINT FK_36AADFFC4C924D98 FOREIGN KEY (template_id_id) REFERENCES mail_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6389D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_company_association ADD CONSTRAINT FK_B9C97A31526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_company_association ADD CONSTRAINT FK_B9C97A3138B53C32 FOREIGN KEY (company_id_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cta ADD CONSTRAINT FK_C43641579D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cta ADD CONSTRAINT FK_C43641574C924D98 FOREIGN KEY (template_id_id) REFERENCES cta_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cta_clicks ADD CONSTRAINT FK_2CD1C405C282A29C FOREIGN KEY (cta_id_id) REFERENCES cta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cta_stats ADD CONSTRAINT FK_EA815B61C282A29C FOREIGN KEY (cta_id_id) REFERENCES cta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cta_template ADD CONSTRAINT FK_B6E78E59D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_logs ADD CONSTRAINT FK_CC2158839D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F4C924D98 FOREIGN KEY (template_id_id) REFERENCES form_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE form_stats ADD CONSTRAINT FK_D400C369FC033A94 FOREIGN KEY (form_id_id) REFERENCES form (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE form_submits ADD CONSTRAINT FK_C5888EA9FC033A94 FOREIGN KEY (form_id_id) REFERENCES form (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE form_template ADD CONSTRAINT FK_265A9AC79D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA79D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC48526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC484C924D98 FOREIGN KEY (template_id_id) REFERENCES mail_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC489D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mail_template ADD CONSTRAINT FK_4AB7DECB9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE segment_campaign_association ADD CONSTRAINT FK_8D3C1D186A411099 FOREIGN KEY (segment_id_id) REFERENCES segment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE segment_campaign_association ADD CONSTRAINT FK_8D3C1D183141FA38 FOREIGN KEY (campaign_id_id) REFERENCES campaign (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE segment_contact_association ADD CONSTRAINT FK_87F6E5DF6A411099 FOREIGN KEY (segment_id_id) REFERENCES segment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE segment_contact_association ADD CONSTRAINT FK_87F6E5DF526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB259D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE attachment DROP CONSTRAINT FK_795FD9BB9D86650F');
        $this->addSql('ALTER TABLE attachment_mail_association DROP CONSTRAINT FK_1981D34C9DAC07E');
        $this->addSql('ALTER TABLE attachment_mail_association DROP CONSTRAINT FK_1981D344B873C38');
        $this->addSql('ALTER TABLE attachment_template_mail_association DROP CONSTRAINT FK_36AADFFCC9DAC07E');
        $this->addSql('ALTER TABLE attachment_template_mail_association DROP CONSTRAINT FK_36AADFFC4C924D98');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E6389D86650F');
        $this->addSql('ALTER TABLE contact_company_association DROP CONSTRAINT FK_B9C97A31526E8E58');
        $this->addSql('ALTER TABLE contact_company_association DROP CONSTRAINT FK_B9C97A3138B53C32');
        $this->addSql('ALTER TABLE cta DROP CONSTRAINT FK_C43641579D86650F');
        $this->addSql('ALTER TABLE cta DROP CONSTRAINT FK_C43641574C924D98');
        $this->addSql('ALTER TABLE cta_clicks DROP CONSTRAINT FK_2CD1C405C282A29C');
        $this->addSql('ALTER TABLE cta_stats DROP CONSTRAINT FK_EA815B61C282A29C');
        $this->addSql('ALTER TABLE cta_template DROP CONSTRAINT FK_B6E78E59D86650F');
        $this->addSql('ALTER TABLE db_logs DROP CONSTRAINT FK_CC2158839D86650F');
        $this->addSql('ALTER TABLE form DROP CONSTRAINT FK_5288FD4F9D86650F');
        $this->addSql('ALTER TABLE form DROP CONSTRAINT FK_5288FD4F4C924D98');
        $this->addSql('ALTER TABLE form_stats DROP CONSTRAINT FK_D400C369FC033A94');
        $this->addSql('ALTER TABLE form_submits DROP CONSTRAINT FK_C5888EA9FC033A94');
        $this->addSql('ALTER TABLE form_template DROP CONSTRAINT FK_265A9AC79D86650F');
        $this->addSql('ALTER TABLE interaction DROP CONSTRAINT FK_378DFDA7526E8E58');
        $this->addSql('ALTER TABLE interaction DROP CONSTRAINT FK_378DFDA79D86650F');
        $this->addSql('ALTER TABLE mail DROP CONSTRAINT FK_5126AC48526E8E58');
        $this->addSql('ALTER TABLE mail DROP CONSTRAINT FK_5126AC484C924D98');
        $this->addSql('ALTER TABLE mail DROP CONSTRAINT FK_5126AC489D86650F');
        $this->addSql('ALTER TABLE mail_template DROP CONSTRAINT FK_4AB7DECB9D86650F');
        $this->addSql('ALTER TABLE segment_campaign_association DROP CONSTRAINT FK_8D3C1D186A411099');
        $this->addSql('ALTER TABLE segment_campaign_association DROP CONSTRAINT FK_8D3C1D183141FA38');
        $this->addSql('ALTER TABLE segment_contact_association DROP CONSTRAINT FK_87F6E5DF6A411099');
        $this->addSql('ALTER TABLE segment_contact_association DROP CONSTRAINT FK_87F6E5DF526E8E58');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB259D86650F');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('DROP TABLE attachment_mail_association');
        $this->addSql('DROP TABLE attachment_template_mail_association');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_company_association');
        $this->addSql('DROP TABLE cta');
        $this->addSql('DROP TABLE cta_clicks');
        $this->addSql('DROP TABLE cta_stats');
        $this->addSql('DROP TABLE cta_template');
        $this->addSql('DROP TABLE db_logs');
        $this->addSql('DROP TABLE form');
        $this->addSql('DROP TABLE form_stats');
        $this->addSql('DROP TABLE form_submits');
        $this->addSql('DROP TABLE form_template');
        $this->addSql('DROP TABLE interaction');
        $this->addSql('DROP TABLE mail');
        $this->addSql('DROP TABLE mail_template');
        $this->addSql('DROP TABLE segment');
        $this->addSql('DROP TABLE segment_campaign_association');
        $this->addSql('DROP TABLE segment_contact_association');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE "user"');
    }
}
