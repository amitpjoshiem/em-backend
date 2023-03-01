-- main database
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'root';
CREATE DATABASE IF NOT EXISTS `swd_db`;
GRANT ALL ON swd_db.* TO 'user'@'%';
-- test database
CREATE USER IF NOT EXISTS 'swd_test'@'%' IDENTIFIED BY 'root';
CREATE DATABASE IF NOT EXISTS `swd_test_db`;
GRANT ALL ON swd_test_db.* TO 'swd_test'@'%';
