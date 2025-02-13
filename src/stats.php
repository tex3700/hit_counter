<?php
require $_SERVER['DOCUMENT_ROOT'] . '/db/db_conn.php';
if (!isset($_SESSION['auth'])) {
    $location = "http://" . $_SERVER['HTTP_HOST'] . "/src/auth/login.php";
    die(header("Location: $location"));
}

// Данные для графиков
$hourly = $pdo->query("
    SELECT 
        DATE_FORMAT(timestamp, '%Y-%m-%d %H:00') AS hour,
        COUNT(DISTINCT ip) as cnt 
    FROM visits 
    GROUP BY hour
")->fetchAll(PDO::FETCH_ASSOC);

$cities = $pdo->query("
    SELECT city, COUNT(*) as cnt 
    FROM visits 
    GROUP BY city
")->fetchAll(PDO::FETCH_ASSOC);

$logout = "http://" . $_SERVER['HTTP_HOST'] . "/src/auth/logout.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Статистика</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Статистика посещений</h1>
<div style="width: 800px;">
    <canvas id="hourlyChart"></canvas>
</div>
<div style="width: 600px;">
    <canvas id="cityChart"></canvas>
</div>
<a href="<?= $logout ?>">Выйти</a>

<script>
    import {Chart} from "chart.js";

    // График по часам
    new Chart(document.getElementById('hourlyChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($hourly, 'hour')) ?>,
            datasets: [{
                label: 'Посещений за час',
                data: <?= json_encode(array_column($hourly, 'cnt')) ?>,
                borderColor: 'blue'
            }]
        }
    });

    // Круговая диаграмма
    new Chart(document.getElementById('cityChart'), {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($cities, 'city')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($cities, 'cnt')) ?>,
                backgroundColor: ['red', 'green', 'blue', 'yellow']
            }]
        }
    });
</script>
</body>
</html>
