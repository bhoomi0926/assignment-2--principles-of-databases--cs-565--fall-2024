\W -- Enable all warnings

DROP DATABASE IF EXISTS `computer_inventory`;
CREATE DATABASE IF NOT EXISTS `computer_inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE USER IF NOT EXISTS 'computer_inventory_manager'@'localhost' IDENTIFIED BY 'b(79yKo8Ei';
GRANT ALL PRIVILEGES ON computer_inventory.* TO 'computer_inventory_manager'@'localhost';

USE computer_inventory;

-- Create the table to store the macOS versions
CREATE TABLE IF NOT EXISTS `macos_versions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `version_name` VARCHAR(255),
    `release_name` VARCHAR(255),
    `darwin_os_number` VARCHAR(10),
    `date_announced` DATE,
    `date_released` DATE,
    `latest_release_date` DATE
);

-- Create the table for the computer inventory
CREATE TABLE IF NOT EXISTS `computer_inventory` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `model` VARCHAR(255) NOT NULL,
    `model_identifier` VARCHAR(255) DEFAULT '',
    `model_number` VARCHAR(255) DEFAULT '',
    `part_number` VARCHAR(255) DEFAULT '',
    `serial_number` VARCHAR(255) NOT NULL,
    `darwin_os_number` INT NOT NULL,
    `latest_supporting_darwin_os_number` INT NOT NULL,
    `url` VARCHAR(255) DEFAULT '',
    `status` VARCHAR(50) DEFAULT 'active'
);

CREATE TABLE `inventory_os_summary` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `model_name` VARCHAR(100) NOT NULL,
    `installed_original_os` VARCHAR(50),
    `last_supported_os` VARCHAR(50)
);

-- Insert sample data for macOS versions
INSERT INTO macos_versions (version_name, release_name, darwin_os_number, date_announced, date_released, latest_release_date)
VALUES
('Mac OS X 10.0', 'Cheetah [internal codename]', '1.3.1', '2001-01-09', '2001-03-24', '2001-06-22'),
('Mac OS X 10.1', 'Puma [internal codename]', '1.4.1/5', '2001-07-18', '2001-10-25', '2002-06-06'),
('Mac OS X 10.2', 'Jaguar', '6', '2002-05-06', '2002-08-24', '2003-10-03'),
('Mac OS X 10.3', 'Panther', '7', '2002-06-23', '2003-10-24', '2005-04-15'),
('Mac OS X 10.4', 'Tiger', '8', '2004-05-04', '2005-04-29', '2007-11-14'),
('Mac OS X 10.5', 'Leopard', '9', '2006-06-26', '2007-10-26', '2009-08-13'),
('Mac OS X 10.6', 'Snow Leopard', '10', '2008-06-09', '2009-08-28', '2011-06-25'),
('Mac OS X 10.7', 'Lion', '11', '2010-10-20', '2011-07-20', '2012-10-04'),
('OS X 10.8', 'Mountain Lion', '12', '2012-02-16', '2012-07-25', '2015-08-13'),
('OS X 10.9', 'Mavericks', '13', '2013-06-10', '2013-10-22', '2016-07-18'),
('OS X 10.10', 'Yosemite', '14', '2014-06-02', '2014-10-16', '2017-07-19'),
('OS X 10.11', 'El Capitan', '15', '2015-06-08', '2015-09-30', '2018-07-09'),
('macOS 10.12', 'Sierra', '16', '2016-06-13', '2016-09-20', '2019-10-26'),
('macOS 10.13', 'High Sierra', '17', '2017-06-05', '2017-09-25', '2020-11-12'),
('macOS 10.14', 'Mojave', '18', '2018-06-04', '2018-09-24', '2021-07-21'),
('macOS 10.15', 'Catalina', '19', '2019-06-03', '2019-10-07', '2022-07-20'),
('macOS 11', 'Big Sur', '20', '2020-06-22', '2020-11-12', '2023-09-11'),
('macOS 12', 'Monterey', '21', '2021-06-07', '2021-10-25', '2024-07-29'),
('macOS 13', 'Ventura', '22', '2022-06-06', '2022-10-24', '2024-09-16'),
('macOS 14', 'Sonoma', '23', '2023-06-05', '2023-09-26', '2024-09-16'),
('macOS 15', 'Sequoia', '24', '2024-06-10', '2024-09-16', '2024-10-03');

-- Insert sample data for the computer inventory
INSERT INTO computer_inventory
(model, model_identifier, model_number, part_number, serial_number, darwin_os_number, latest_supporting_darwin_os_number, url, status)
VALUES
('MacBook (Retina, 12-inch, Early 2015)', 'MacBook8,1', 'A1534', 'Z0RN00003', '2QJ02DC0GCN2', 15, 20, 'https://support.apple.com/en-us/112442', 'active'),
('MacBook Pro (15-inch, 2.53GHz, Mid 2009)', 'MacBookPro5,4', '', 'MC118LL/A', '9W89311B7XJ', 9, 15, 'https://support.apple.com/en-us/112624', 'active'),
('MacBook Pro (15-inch, 2016)', 'MacBookPro13,3', 'A1707', 'Z0SH0004V', 'C0287FGTF1SQ', 17, 21, 'https://support.apple.com/en-us/111975', 'active'),
('iMac (Retina 5K, 27-inch, Late 2014)', 'iMac15,1', 'A1419', 'MF886xx/A', 'CL145FY102N4', 14, 20, 'https://support.apple.com/en-us/112436', 'active'),
('Mac Pro (Late 2013)', 'MacPro6', 'A1481', 'ME253xx/A', 'MD878xx/A', 18, 21, 'https://support.apple.com/en-us/112025', 'active'),
('MacBook Pro (15-inch, 2.4GHz, Mid 2010)', 'MacBookPro6,2', '', 'MC118LL/A', 'MNW8044FAGU', 10, 17, 'https://support.apple.com/en-us/112605', 'active'),
('Mac Pro (Mid 2010)', 'MacPro5,1', 'A1289', 'MC560LL/A', 'YM1LUEUE310', 10, 18, 'https://support.apple.com/en-us/112578', 'active');

INSERT INTO inventory_os_summary (model_name, installed_original_os, last_supported_os)
VALUES
('MacBook (Retina, 12-inch, Early 2015)', 'El Capitán', 'Big Sur'),
('MacBook Pro (15-inch, 2.53GHz, Mid 2009)', 'Leopard', 'El Capitán'),
('MacBook Pro (15-inch, 2016)', 'High Sierra', 'Monterey'),
('iMac (Retina 5K, 27-inch, Late 2014)', 'Yosemite', 'Big Sur'),
('Mac Pro (Late 2013)', 'Mojave', 'Monterey'),
('MacBook Pro (15-inch, 2.4GHz, Mid 2010)', 'Snow Leopard', 'High Sierra'),
('Mac Pro (Mid 2010)', 'Snow Leopard', 'Mojave');
