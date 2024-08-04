<?php

declare(strict_types=1);

require __DIR__ . '/../../src/App/App.php';

try {
    $dbName = getenv('DB_NAME');
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;port=%s;charset=utf8',
        getenv('DB_HOST'),
        $dbName,
        getenv('DB_PORT')
    );
    $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("DROP DATABASE IF EXISTS " . $dbName);
    echo '[OK] Database dropped successfully' . PHP_EOL;

    $pdo->exec("CREATE DATABASE " . $dbName);
    echo '[OK] Database created successfully' . PHP_EOL;

    $pdo->exec("USE " . $dbName);
    echo '[OK] Database selected successfully' . PHP_EOL;

    $sql = file_get_contents(__DIR__ . '/../../database/database.sql');
    $pdo->exec($sql);
    echo '[OK] Records inserted successfully' . PHP_EOL;
} catch (PDOException $exception) {
    echo '[ERROR] ' . $exception->getMessage() . PHP_EOL;
}