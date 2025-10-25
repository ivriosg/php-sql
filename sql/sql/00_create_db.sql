-- 00_create_db.sql
CREATE DATABASE IF NOT EXISTS qr_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE qr_app;

DROP TABLE IF EXISTS visits_log;
DROP TABLE IF EXISTS metrics;
DROP TABLE IF EXISTS create_link;

CREATE TABLE create_link (
  id INT AUTO_INCREMENT PRIMARY KEY,
  link VARCHAR(2048) NOT NULL,
  campaign_source VARCHAR(100) NOT NULL,
  campaign_medium VARCHAR(100) NOT NULL,
  campaign_name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_link_source_medium_name (link(255), campaign_source, campaign_medium, campaign_name)
) ENGINE=InnoDB;

CREATE TABLE metrics (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_link INT NOT NULL,
  campaign_source VARCHAR(100) NOT NULL,
  campaign_medium  VARCHAR(100) NOT NULL,
  campaign_name    VARCHAR(100) NOT NULL,
  visitas INT NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_metric (id_link, campaign_source, campaign_medium, campaign_name),
  CONSTRAINT fk_metrics_link FOREIGN KEY (id_link) REFERENCES create_link(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE visits_log (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  id_link INT NOT NULL,
  campaign_source VARCHAR(100) NOT NULL,
  campaign_medium  VARCHAR(100) NOT NULL,
  campaign_name    VARCHAR(100) NOT NULL,
  ip VARBINARY(16) NULL,
  user_agent VARCHAR(255) NULL,
  visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_visits (id_link, visited_at),
  CONSTRAINT fk_visits_link FOREIGN KEY (id_link) REFERENCES create_link(id) ON DELETE CASCADE
) ENGINE=InnoDB;
