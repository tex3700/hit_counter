<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/mobiledetect/mobiledetectlib/src/MobileDetect.php';
require $_SERVER['DOCUMENT_ROOT'] .'/db/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] == 'track') {
        // Получение IP-адреса
        $ip = $_POST['ip'] ?? '';
        // Получение города
        $city = $_POST['city'] ?? 'Unknown';

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
    }
}

