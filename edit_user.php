<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'owner') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$name, $email, $role, $id]);

    header('Location: manage_users.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-box">
        <h2>Modifier l'utilisateur</h2>
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            <select name="role">
                <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Étudiant</option>
                <option value="owner" <?= $user['role'] === 'owner' ? 'selected' : '' ?>>Propriétaire</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
</body>
</html>
