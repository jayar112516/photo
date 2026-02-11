CREATE DATABASE photobook;
USE photobook;

CREATE TABLE photos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(255),
  caption TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
