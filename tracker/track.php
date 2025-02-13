<?php
require '../vendor/autoload.php';
require '../vendor/mobiledetect/mobiledetectlib/src/MobileDetect.php';
require '../config/config.php';
require '../db/db_conn.php';

// Получение IP-адреса
$ip = $_SERVER['REMOTE_ADDR'];

// Определение города через IP-API (HTTP)
$city = 'Unknown';
$response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=city");
if ($response) {
    $geoData = json_decode($response, true);
    $city = $geoData['city'] ?? $city;
}

// Определение типа устройства
$detect = new Mobile_Detect();
$detect->setUserAgent($_POST['userAgent'] ?? '');
$device = 'desktop';
if ($detect->isMobile()) $device = 'mobile';
if ($detect->isTablet()) $device = 'tablet';

// Сохранение в SQLite
$stmt = $pdo->prepare("INSERT INTO visits (ip, city, device) VALUES (?, ?, ?)");
$stmt->execute([$ip, $city, $device]);

header('Content-Type: application/json');
echo json_encode(['status' => 'ok']);
