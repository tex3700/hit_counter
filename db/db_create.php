<?php
function executeQuery($pdo, $query): void
{
    try {
        $pdo->exec($query);
        echo "База данных успешно создана.\n";
    } catch (\PDOException $e) {
        echo "Error executing query: " . $e->getMessage() . "\n";
    }
}

