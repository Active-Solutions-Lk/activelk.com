-- ─────────────────────────────────────────────
--  ACTIVE SOLUTIONS  |  schema.sql  |  MySQL 8
-- ─────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS solutions (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug        VARCHAR(120) NOT NULL UNIQUE,
  badge       VARCHAR(80),
  title       VARCHAR(200) NOT NULL,
  body        TEXT,
  icon        VARCHAR(40),
  side        ENUM('left','right') DEFAULT 'left',
  tone        ENUM('light','dark')  DEFAULT 'light',
  obj_x       TINYINT UNSIGNED DEFAULT 50,
  video_t     JSON,
  scroll_vh   JSON,
  cta_label   VARCHAR(80),
  cta_href    VARCHAR(255),
  sort_order  SMALLINT DEFAULT 0,
  is_active   TINYINT(1) DEFAULT 1,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS projects (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug        VARCHAR(120) NOT NULL UNIQUE,
  title       VARCHAR(200) NOT NULL,
  client      VARCHAR(120),
  industry    VARCHAR(80),
  summary     TEXT,
  body        LONGTEXT,
  cover_img   VARCHAR(255),
  tags        JSON,
  is_featured TINYINT(1) DEFAULT 0,
  is_active   TINYINT(1) DEFAULT 1,
  published_at DATE,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS blog_posts (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug        VARCHAR(120) NOT NULL UNIQUE,
  title       VARCHAR(255) NOT NULL,
  excerpt     VARCHAR(500),
  body        LONGTEXT,
  cover_img   VARCHAR(255),
  author      VARCHAR(120),
  tags        JSON,
  is_active   TINYINT(1) DEFAULT 1,
  published_at DATE,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_leads (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(120) NOT NULL,
  email       VARCHAR(255) NOT NULL,
  company     VARCHAR(120),
  phone       VARCHAR(30),
  interest    VARCHAR(80),
  reason      VARCHAR(40),
  message     TEXT,
  source_page VARCHAR(255),
  ip_address  VARCHAR(45),
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS site_settings (
  `key`       VARCHAR(80) NOT NULL PRIMARY KEY,
  `value`     TEXT,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reseller_leads (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  company_name  VARCHAR(150) NOT NULL,
  contact_name  VARCHAR(120) NOT NULL,
  email         VARCHAR(255) NOT NULL,
  phone         VARCHAR(30)  NOT NULL,
  website       VARCHAR(255),
  message       TEXT,
  status        ENUM('new','reviewing','approved','rejected') DEFAULT 'new',
  ip_address    VARCHAR(45),
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
