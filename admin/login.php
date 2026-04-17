<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth.php';

if (isLoggedIn()) {
    header('Location: /admin/dashboard.php');
    exit;
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errorMessage = 'Vul gebruikersnaam en wachtwoord in.';
    } else {
        try {
            $pdo = getPDO();
            if (attemptLogin($pdo, $username, $password)) {
                header('Location: /admin/dashboard.php');
                exit;
            }
            $errorMessage = 'Ongeldige inloggegevens.';
        } catch (Throwable $exception) {
            $errorMessage = 'Kan niet verbinden met de database. Controleer je DB instellingen.';

            $remoteAddress = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
            $isLocalRequest = in_array($remoteAddress, ['127.0.0.1', '::1'], true);

            if ($isLocalRequest) {
                $errorMessage .= ' Details: ' . $exception->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard Login</h1>

        <?php if ($errorMessage !== ''): ?>
            <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-700"><?php echo e($errorMessage); ?></div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Gebruikersnaam</label>
                <input type="text" id="username" name="username" class="mt-1 w-full rounded border border-gray-300 p-2" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                <input type="password" id="password" name="password" class="mt-1 w-full rounded border border-gray-300 p-2" required>
            </div>
            <button type="submit" class="w-full rounded bg-gray-900 py-2 text-white hover:bg-black">Inloggen</button>
        </form>
    </div>
</body>
</html>
