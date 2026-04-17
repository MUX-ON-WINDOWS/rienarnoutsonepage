<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth.php';

requireAdminLogin();

$feedbackMessage = '';
$feedbackType = 'success';

function isAllowedCategory(string $category): bool
{
    return in_array($category, ['brons', 'keramiek'], true);
}

function validateImageUpload(array $file): ?string
{
    if (!isset($file['tmp_name'], $file['name'], $file['error']) || !is_string($file['tmp_name']) || !is_string($file['name'])) {
        return 'Ongeldige upload.';
    }

    if ((int) $file['error'] !== UPLOAD_ERR_OK) {
        return 'Upload mislukt.';
    }

    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return 'Bestand is geen geldige afbeelding.';
    }

    $extension = strtolower((string) pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($extension, $allowedExtensions, true)) {
        return 'Alleen JPG, PNG of WEBP zijn toegestaan.';
    }

    return null;
}

function saveUploadedImage(array $file): string
{
    $extension = strtolower((string) pathinfo((string) $file['name'], PATHINFO_EXTENSION));
    $safeName = bin2hex(random_bytes(16)) . '.' . $extension;

    $relativePath = 'uploads/portfolio/' . $safeName;
    $targetPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $relativePath;

    if (!move_uploaded_file((string) $file['tmp_name'], $targetPath)) {
        throw new RuntimeException('Kon bestand niet opslaan.');
    }

    return str_replace('\\', '/', $relativePath);
}

function deleteImageFile(string $relativePath): void
{
    if (strpos($relativePath, 'uploads/portfolio/') !== 0) {
        return;
    }

    $fullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    if (is_file($fullPath)) {
        unlink($fullPath);
    }
}

try {
    $pdo = getPDO();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = (string) ($_POST['action'] ?? '');

        if ($action === 'add') {
            $category = trim((string) ($_POST['category'] ?? ''));
            $titel = trim((string) ($_POST['titel'] ?? ''));
            $afmetingHoogte = trim((string) ($_POST['afmeting_hoogte'] ?? ''));
            $file = $_FILES['foto'] ?? null;

            if (!isAllowedCategory($category)) {
                throw new RuntimeException('Kies een geldige categorie.');
            }
            if ($titel === '' || $afmetingHoogte === '') {
                throw new RuntimeException('Titel en afmeting/hoogte zijn verplicht.');
            }
            if (!is_array($file)) {
                throw new RuntimeException('Foto is verplicht.');
            }

            $uploadError = validateImageUpload($file);
            if ($uploadError !== null) {
                throw new RuntimeException($uploadError);
            }

            $relativePath = saveUploadedImage($file);

            $insert = $pdo->prepare('INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES (:foto, :category, :titel, :afmeting_hoogte)');
            $insert->execute([
                'foto' => $relativePath,
                'category' => $category,
                'titel' => $titel,
                'afmeting_hoogte' => $afmetingHoogte,
            ]);

            $feedbackMessage = 'Foto toegevoegd.';
        }

        if ($action === 'update') {
            $id = (int) ($_POST['id'] ?? 0);
            $category = trim((string) ($_POST['category'] ?? ''));
            $titel = trim((string) ($_POST['titel'] ?? ''));
            $afmetingHoogte = trim((string) ($_POST['afmeting_hoogte'] ?? ''));

            if ($id < 1) {
                throw new RuntimeException('Ongeldig foto ID.');
            }
            if (!isAllowedCategory($category)) {
                throw new RuntimeException('Kies een geldige categorie.');
            }
            if ($titel === '' || $afmetingHoogte === '') {
                throw new RuntimeException('Titel en afmeting/hoogte zijn verplicht.');
            }

            $select = $pdo->prepare('SELECT foto FROM foto_data WHERE id = :id LIMIT 1');
            $select->execute(['id' => $id]);
            $currentPhoto = $select->fetch();

            if (!$currentPhoto) {
                throw new RuntimeException('Foto niet gevonden.');
            }

            $newPath = (string) $currentPhoto['foto'];
            $newUpload = $_FILES['foto'] ?? null;

            if (is_array($newUpload) && (int) ($newUpload['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $uploadError = validateImageUpload($newUpload);
                if ($uploadError !== null) {
                    throw new RuntimeException($uploadError);
                }

                $newPath = saveUploadedImage($newUpload);
                deleteImageFile((string) $currentPhoto['foto']);
            }

            $update = $pdo->prepare('UPDATE foto_data SET foto = :foto, category = :category, titel = :titel, afmeting_hoogte = :afmeting_hoogte WHERE id = :id');
            $update->execute([
                'id' => $id,
                'foto' => $newPath,
                'category' => $category,
                'titel' => $titel,
                'afmeting_hoogte' => $afmetingHoogte,
            ]);

            $feedbackMessage = 'Foto bijgewerkt.';
        }

        if ($action === 'delete') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id < 1) {
                throw new RuntimeException('Ongeldig foto ID.');
            }

            $select = $pdo->prepare('SELECT foto FROM foto_data WHERE id = :id LIMIT 1');
            $select->execute(['id' => $id]);
            $photo = $select->fetch();

            if (!$photo) {
                throw new RuntimeException('Foto niet gevonden.');
            }

            $delete = $pdo->prepare('DELETE FROM foto_data WHERE id = :id');
            $delete->execute(['id' => $id]);

            deleteImageFile((string) $photo['foto']);
            $feedbackMessage = 'Foto verwijderd.';
        }
    }

    $photosStmt = $pdo->query('SELECT id, foto, category, titel, afmeting_hoogte FROM foto_data ORDER BY id DESC');
    $photos = $photosStmt->fetchAll();
} catch (Throwable $exception) {
    $feedbackType = 'error';
    $feedbackMessage = $exception->getMessage();
    $photos = [];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Dashboard</title>
    <link href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">Portfolio Dashboard</h1>
            <div class="space-x-3">
                <a href="/" class="text-sm text-gray-700 hover:underline">Naar website</a>
                <a href="/admin/logout.php" class="rounded bg-gray-900 px-3 py-2 text-sm text-white hover:bg-black">Uitloggen</a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 space-y-8">
        <?php if ($feedbackMessage !== ''): ?>
            <?php if ($feedbackType === 'error'): ?>
                <div class="rounded border border-red-200 bg-red-50 p-3 text-red-700">
                    <?php echo e($feedbackMessage); ?>
                </div>
            <?php else: ?>
                <div class="rounded border border-green-200 bg-green-50 p-3 text-green-700">
                    <?php echo e($feedbackMessage); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <section class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-lg font-semibold mb-4">Nieuwe foto toevoegen</h2>
            <form method="post" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                <input type="hidden" name="action" value="add">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Categorie</label>
                    <select name="category" class="mt-1 w-full rounded border border-gray-300 p-2" required>
                        <option value="brons">Brons</option>
                        <option value="keramiek">Keramiek</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titel</label>
                    <input type="text" name="titel" class="mt-1 w-full rounded border border-gray-300 p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Afmeting / hoogte</label>
                    <input type="text" name="afmeting_hoogte" class="mt-1 w-full rounded border border-gray-300 p-2" placeholder="bijv. 60 cm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Foto</label>
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp" class="mt-1 w-full" required>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white hover:bg-black">Toevoegen</button>
                </div>
            </form>
        </section>

        <section class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-lg font-semibold mb-4">Bestaande foto's</h2>

            <?php if (count($photos) === 0): ?>
                <p class="text-gray-600">Nog geen foto's gevonden in de database.</p>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($photos as $photo): ?>
                        <form method="post" enctype="multipart/form-data" class="rounded border border-gray-200 p-4">
                            <input type="hidden" name="id" value="<?php echo (int) $photo['id']; ?>">
                            <div class="grid gap-4 md:grid-cols-5 items-end">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Preview</label>
                                    <img src="/<?php echo e((string) $photo['foto']); ?>" alt="<?php echo e((string) $photo['titel']); ?>" class="mt-1 h-20 w-20 rounded object-cover border">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Categorie</label>
                                    <select name="category" class="mt-1 w-full rounded border border-gray-300 p-2" required>
                                        <option value="brons" <?php echo $photo['category'] === 'brons' ? 'selected' : ''; ?>>Brons</option>
                                        <option value="keramiek" <?php echo $photo['category'] === 'keramiek' ? 'selected' : ''; ?>>Keramiek</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Titel</label>
                                    <input type="text" name="titel" class="mt-1 w-full rounded border border-gray-300 p-2" value="<?php echo e((string) $photo['titel']); ?>" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Afmeting / hoogte</label>
                                    <input type="text" name="afmeting_hoogte" class="mt-1 w-full rounded border border-gray-300 p-2" value="<?php echo e((string) $photo['afmeting_hoogte']); ?>" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nieuwe foto (optioneel)</label>
                                    <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp" class="mt-1 w-full text-sm">
                                </div>
                            </div>
                            <div class="mt-4 flex gap-3">
                                <button type="submit" name="action" value="update" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Opslaan</button>
                                <button type="submit" name="action" value="delete" class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700" onclick="return confirm('Weet je zeker dat je deze foto wilt verwijderen?');">Verwijderen</button>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
