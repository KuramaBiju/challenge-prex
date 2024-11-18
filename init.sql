CREATE DATABASE IF NOT EXISTS challenge_prex;
CREATE USER IF NOT EXISTS 'challenge_user'@'%' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON challenge_prex.* TO 'challenge_user'@'%';
FLUSH PRIVILEGES;