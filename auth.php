<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function isLoggedIn(): bool
{
    return isset($_SESSION['admin_user_id']) && is_int($_SESSION['admin_user_id']);
}

function requireAdminLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function attemptLogin(PDO $pdo, string $username, string $password): bool
{
    $statement = $pdo->prepare('SELECT id, password_hash FROM loginuser WHERE username = :username LIMIT 1');
    $statement->execute(['username' => $username]);
    $user = $statement->fetch();

    if (!$user) {
        return false;
    }

    if (!password_verify($password, (string) $user['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['admin_user_id'] = (int) $user['id'];

    return true;
}

function logoutAdmin(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}
