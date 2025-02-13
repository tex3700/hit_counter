<?php
require 'db_conn.php';
require 'db_create.php';

$createTablesQuery = "
CREATE TABLE visits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ip VARCHAR(45),
    city VARCHAR(100) NOT NULL,
    device VARCHAR(20) NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX idx_timestamp ON visits(timestamp);
CREATE INDEX idx_city ON visits(city);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(250) NOT NULL,
    token VARCHAR(250),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

executeQuery($pdo, $createTablesQuery);

