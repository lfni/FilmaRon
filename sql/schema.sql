
CREATE DATABASE IF NOT EXISTS filmaron CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE filmaron;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(64) UNIQUE NOT NULL,
  email VARCHAR(191) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS titles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(191) UNIQUE NOT NULL,
  type ENUM('movie','series') NOT NULL,
  title_fa VARCHAR(255) NOT NULL,
  title_en VARCHAR(255) NULL,
  year INT NULL,
  mpaa VARCHAR(10) NULL,
  has_dub TINYINT(1) DEFAULT 0,
  has_sub TINYINT(1) DEFAULT 1,
  online_play TINYINT(1) DEFAULT 0,
  imdb DECIMAL(3,1) NULL,
  score TINYINT UNSIGNED NULL,
  status ENUM('hardsub','softsub','subtitle','complete','ongoing') NULL,
  updated_note VARCHAR(255) NULL,
  poster VARCHAR(255) NOT NULL,
  schedule_day TINYINT UNSIGNED NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS genres ( id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(64) UNIQUE NOT NULL ) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS title_genres (
  title_id INT NOT NULL, genre_id INT NOT NULL,
  PRIMARY KEY (title_id, genre_id),
  FOREIGN KEY (title_id) REFERENCES titles(id) ON DELETE CASCADE,
  FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS countries ( id INT AUTO_INCREMENT PRIMARY KEY, code CHAR(2) UNIQUE NOT NULL, name VARCHAR(128) NOT NULL ) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS title_countries (
  title_id INT NOT NULL, country_id INT NOT NULL,
  PRIMARY KEY (title_id, country_id),
  FOREIGN KEY (title_id) REFERENCES titles(id) ON DELETE CASCADE,
  FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS episodes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title_id INT NOT NULL, season INT DEFAULT 1, episode INT NOT NULL,
  name VARCHAR(255) NULL, download_url VARCHAR(255) NULL, stream_url VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (title_id) REFERENCES titles(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS favorites (
  user_id INT NOT NULL, title_id INT NOT NULL,
  PRIMARY KEY (user_id, title_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (title_id) REFERENCES titles(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT IGNORE INTO genres (name) VALUES ('درام'),('اکشن'),('عاشقانه'),('کمدی'),('جنایی'),('تاریخی');
INSERT IGNORE INTO countries (code,name) VALUES ('KR','Korea'),('CN','China'),('JP','Japan'),('IR','Iran'),('TH','Thailand');

INSERT IGNORE INTO titles (slug,type,title_fa,title_en,year,mpaa,has_dub,has_sub,online_play,imdb,score,status,updated_note,poster,schedule_day)
VALUES
('my-dream', 'series', 'رویای من', 'My Dream', 2024, 'PG-13', 0, 1, 1, 8.2, 92, 'ongoing', 'هاردساب قسمت 12 اضافه شد', '/public/assets/img/poster1.jpg', 1),
('shadow-chase', 'movie', 'تعقیب سایه', 'Shadow Chase', 2023, 'R', 1, 1, 0, 7.5, 80, 'complete', NULL, '/public/assets/img/poster2.jpg', NULL);

INSERT IGNORE INTO title_genres (title_id, genre_id)
SELECT t.id, g.id FROM titles t JOIN genres g
  ON ( (t.slug='my-dream' AND g.name IN ('درام','عاشقانه')) OR (t.slug='shadow-chase' AND g.name IN ('اکشن','جنایی')) );

INSERT IGNORE INTO title_countries (title_id, country_id)
SELECT t.id, c.id FROM titles t JOIN countries c
  ON ( (t.slug='my-dream' AND c.code='KR') OR (t.slug='shadow-chase' AND c.code='IR') );

INSERT IGNORE INTO episodes (title_id, season, episode, name, download_url, stream_url)
SELECT id, 1, 12, 'Episode 12', 'https://example.com/dl/ep12.mp4', 'https://example.com/stream/ep12.m3u8' FROM titles WHERE slug='my-dream';
