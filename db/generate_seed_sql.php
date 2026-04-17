<?php
declare(strict_types=1);

function getArgValue(array $argv, string $name): ?string
{
    $prefix = '--' . $name . '=';
    foreach ($argv as $arg) {
        if (strpos($arg, $prefix) === 0) {
            return trim(substr($arg, strlen($prefix)));
        }
    }

    return null;
}

function generatePassword(int $length = 16): string
{
    $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
    $maxIndex = strlen($alphabet) - 1;
    $password = '';

    for ($index = 0; $index < $length; $index++) {
        $password .= $alphabet[random_int(0, $maxIndex)];
    }

    return $password;
}

function quoteSql(string $value): string
{
    return "'" . str_replace("'", "''", $value) . "'";
}

$username = getArgValue($argv, 'username') ?: 'admin';
$password = getArgValue($argv, 'password') ?: '';
$outputPath = getArgValue($argv, 'output') ?: (__DIR__ . '/seed_generated.sql');
$generatedPassword = false;

if ($password === '') {
    $password = generatePassword();
    $generatedPassword = true;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$defaultPhotos = [
    ['foto' => 'brons/cobra.jpg', 'category' => 'brons', 'titel' => 'Cobra', 'afmeting_hoogte' => '33 cm'],
    ['foto' => 'brons/jumeau.jpg', 'category' => 'brons', 'titel' => 'Jumeau', 'afmeting_hoogte' => '60 cm'],
    ['foto' => 'brons/vanity.jpg', 'category' => 'brons', 'titel' => 'Vanity', 'afmeting_hoogte' => '144 cm'],
    ['foto' => 'brons/volante.jpg', 'category' => 'brons', 'titel' => 'Volante', 'afmeting_hoogte' => '97 cm'],
    ['foto' => 'brons/voltige.jpg', 'category' => 'brons', 'titel' => 'Voltige', 'afmeting_hoogte' => '33 cm'],
    ['foto' => 'keramiek/assis.jpg', 'category' => 'keramiek', 'titel' => 'Assis', 'afmeting_hoogte' => '40 cm'],
    ['foto' => 'keramiek/bovenOnder.jpg', 'category' => 'keramiek', 'titel' => 'Boven & onder', 'afmeting_hoogte' => '24 cm'],
    ['foto' => 'keramiek/Overdenking.jpg', 'category' => 'keramiek', 'titel' => 'Overdenking', 'afmeting_hoogte' => '86 cm'],
    ['foto' => 'keramiek/tors.jpg', 'category' => 'keramiek', 'titel' => 'Tors', 'afmeting_hoogte' => '62 cm'],
    ['foto' => 'keramiek/trio.jpeg', 'category' => 'keramiek', 'titel' => 'Trio', 'afmeting_hoogte' => '35 cm'],
    ['foto' => 'keramiek/relief.jpg', 'category' => 'keramiek', 'titel' => 'Relief', 'afmeting_hoogte' => '94 cm'],
];

$sqlLines = [];
$sqlLines[] = '-- Generated seed SQL';
$sqlLines[] = 'START TRANSACTION;';
$sqlLines[] = '';
$sqlLines[] = 'INSERT INTO loginuser (username, password_hash)';
$sqlLines[] = 'VALUES (' . quoteSql($username) . ', ' . quoteSql($passwordHash) . ')';
$sqlLines[] = 'ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash);';
$sqlLines[] = '';
$sqlLines[] = 'DELETE FROM foto_data;';
$sqlLines[] = '';

foreach ($defaultPhotos as $photo) {
    $sqlLines[] = 'INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('
        . quoteSql($photo['foto']) . ', '
        . quoteSql($photo['category']) . ', '
        . quoteSql($photo['titel']) . ', '
        . quoteSql($photo['afmeting_hoogte']) . ');';
}

$sqlLines[] = '';
$sqlLines[] = 'COMMIT;';
$sqlLines[] = '';

if (file_put_contents($outputPath, implode(PHP_EOL, $sqlLines)) === false) {
    fwrite(STDERR, 'Kon SQL-bestand niet schrijven: ' . $outputPath . PHP_EOL);
    exit(1);
}

echo 'SQL seedbestand gemaakt: ' . $outputPath . PHP_EOL;
echo 'Gebruiker: ' . $username . PHP_EOL;

if ($generatedPassword) {
    echo 'Wachtwoord (automatisch gegenereerd): ' . $password . PHP_EOL;
} else {
    echo 'Wachtwoord ingesteld via --password argument.' . PHP_EOL;
}

echo 'Importeer dit SQL-bestand via phpMyAdmin op je hostingdatabase.' . PHP_EOL;
