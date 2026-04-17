<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';

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

$username = getArgValue($argv, 'username') ?: 'admin';
$password = getArgValue($argv, 'password') ?: '';
$generatedPassword = false;

if ($password === '') {
    $password = generatePassword();
    $generatedPassword = true;
}

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

try {
    $pdo = getPDO();
    $pdo->beginTransaction();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $upsertUser = $pdo->prepare(
        'INSERT INTO loginuser (username, password_hash)
         VALUES (:username, :password_hash)
         ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)'
    );

    $upsertUser->execute([
        'username' => $username,
        'password_hash' => $passwordHash,
    ]);

    $pdo->exec('DELETE FROM foto_data');

    $insertPhoto = $pdo->prepare(
        'INSERT INTO foto_data (foto, category, titel, afmeting_hoogte)
         VALUES (:foto, :category, :titel, :afmeting_hoogte)'
    );

    foreach ($defaultPhotos as $photo) {
        $insertPhoto->execute($photo);
    }

    $pdo->commit();

    echo 'Seed voltooid.' . PHP_EOL;
    echo 'Gebruiker: ' . $username . PHP_EOL;
    echo 'Fotos geplaatst: ' . count($defaultPhotos) . PHP_EOL;

    if ($generatedPassword) {
        echo 'Wachtwoord (automatisch gegenereerd): ' . $password . PHP_EOL;
        echo 'Sla dit wachtwoord direct op en wijzig het daarna via een nieuwe seed-run.' . PHP_EOL;
    } else {
        echo 'Wachtwoord ingesteld via --password argument.' . PHP_EOL;
    }
} catch (Throwable $exception) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    fwrite(STDERR, 'Seed mislukt: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
