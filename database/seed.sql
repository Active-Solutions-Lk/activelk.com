-- ─────────────────────────────────────────────
--  ACTIVE SOLUTIONS  |  seed.sql  |  MySQL 8
-- ─────────────────────────────────────────────

-- Seed Solutions
INSERT INTO solutions (slug, badge, title, body, icon, side, tone, obj_x, video_t, scroll_vh, cta_label, cta_href, sort_order, is_active)
VALUES
  ('intro', 'Value Added Distributor', 'Active Solutions', 'Storage, networking and security solutions from the brands businesses trust.', 'shield', 'left', 'dark', 50, '[0, 0, 1.0, 3]', '[0, 100, 200]', 'Explore Solutions', '#contact', 0, 1),
  ('nas', 'Synology NAS', 'Storage that never slows you down', 'Synology NAS for backup, file sharing and secure team collaboration.', 'shield', 'left', 'light', 70, '[3, 5, 8.5, 8.8]', '[80, 200, 30]', 'View NAS Solutions', '#contact', 1, 1),
  ('switch', 'BDCOM', 'Switching built for scale', 'Managed enterprise switches for reliable, high-density networks.', 'shield', 'right', 'light', 30, '[8.8, 9.8, 14.4, 14.7]', '[60, 200, 30]', 'View Switches', '#contact', 2, 1),
  ('router', 'DrayTek', 'Secure connectivity, everywhere', 'VPN-ready routers and firewalls for branches and growing teams.', 'shield', 'right', 'light', 30, '[14.7, 16, 21, 22]', '[70, 200, 50]', 'View Routers', '#contact', 3, 1),
  ('software', 'SYNALYZE', 'See every file event instantly', 'SYNALYZE turns NAS logs into real-time alerts and audit-ready reports.', 'bulb', 'left', 'light', 70, '[22, 24, 27.166, 27.166]', '[80, 200, 0]', 'Book a Demo', '#contact', 4, 1)
ON DUPLICATE KEY UPDATE title=VALUES(title), body=VALUES(body);

-- Seed Projects
INSERT INTO projects (slug, title, client, industry, summary, body, cover_img, tags, is_featured, is_active, published_at)
VALUES
  ('bank-datacenter-storage', 'High-Availability Synology NAS for Commercial Bank', 'National Commercial Bank', 'Finance', 'Multi-petabyte redundant backup and enterprise disaster recovery cluster implementation.', 'Detailed case study on how we engineered active-active redundant storage...', '', '["NAS", "Disaster Recovery", "Synology"]', 1, 1, '2026-01-15'),
  ('university-campus-switching', 'Campus-Wide 10G BDCOM Switching Infrastructure', 'Metropolitan University', 'Education', 'High density core-distribution-access network connecting 15 faculties and research labs.', 'Deployment of 10G fiber backbone switches and PoE+ edge ports...', '', '["Switching", "10G", "BDCOM"]', 1, 1, '2026-02-10')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- Seed Site Settings
INSERT INTO site_settings (`key`, `value`)
VALUES
  ('site_title', 'Active Solutions | Value Added Distributor'),
  ('site_description', 'Storage, networking and security solutions from the brands businesses trust.'),
  ('contact_email', 'info@activesolutions.lk'),
  ('hero_badge', 'Value Added Distributor'),
  ('hero_tagline', 'Storage, networking and security solutions from the brands businesses trust.')
ON DUPLICATE KEY UPDATE `value`=VALUES(`value`);
