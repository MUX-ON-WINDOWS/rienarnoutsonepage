<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$dbConfig = [
    'host' => getenv('DB_HOST') ?: 'database-5020255434.webspace-host.com',
    'port' => getenv('DB_PORT') ?: '3306',
    'database' => getenv('DB_NAME') ?: 'dbs15574211',
    'username' => getenv('DB_USER') ?: 'dbu5537751',
    'password' => getenv('DB_PASS') ?: 'Riar@2405!',
];

$localConfigPath = __DIR__ . '/config.local.php';
if (is_file($localConfigPath)) {
    $localConfig = require $localConfigPath;
    if (is_array($localConfig)) {
        $dbConfig = array_merge($dbConfig, $localConfig);
    }
}

function getPDO(): PDO
{
    global $dbConfig;

    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    if (!extension_loaded('pdo_mysql')) {
        throw new RuntimeException('PHP extensie pdo_mysql ontbreekt. Activeer pdo_mysql in je php.ini en herstart je webserver.');
    }

    $host = (string) ($dbConfig['host'] ?? '127.0.0.1');
    $port = (string) ($dbConfig['port'] ?? '3306');
    $database = (string) ($dbConfig['database'] ?? '');
    $username = (string) ($dbConfig['username'] ?? '');
    $password = (string) ($dbConfig['password'] ?? '');

    if ($database === '' || $username === '') {
        throw new RuntimeException('Database configuratie ontbreekt. Stel DB_NAME en DB_USER in.');
    }

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);

    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 3,
    ]);

    return $pdo;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
