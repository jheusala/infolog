CREATE TABLE `infodesk_user` (
    user_id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    updated           TIMESTAMP NOT NULL DEFAULT 0,
    created           TIMESTAMP NOT NULL DEFAULT 0,
    tag               VARCHAR(255) UNIQUE NOT NULL DEFAULT '',
    PRIMARY KEY(user_id)) CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE `infodesk_log` (
    log_id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id          BIGINT UNSIGNED NOT NULL DEFAULT 0,
    updated          TIMESTAMP NOT NULL DEFAULT 0,
    created          TIMESTAMP NOT NULL DEFAULT 0,
    domain           VARCHAR(255) NOT NULL DEFAULT '',
    remote_addr      VARCHAR(255) NOT NULL DEFAULT '',
    msg              TEXT NOT NULL DEFAULT '',
    PRIMARY KEY(log_id)) CHARACTER SET utf8 ENGINE=InnoDB;

/*
ALTER TABLE `infodesk_log` ADD remote_addr      VARCHAR(255) NOT NULL DEFAULT '' AFTER created;
ALTER TABLE `infodesk_log` ADD domain VARCHAR(255) NOT NULL DEFAULT '' AFTER created;
ALTER TABLE `infodesk_log` ADD user_tag      VARCHAR(255) NOT NULL DEFAULT '' AFTER remote_addr;
ALTER TABLE `infodesk_log` ADD user_id          BIGINT UNSIGNED NOT NULL DEFAULT 0 AFTER log_id;
*/
