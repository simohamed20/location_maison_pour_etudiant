<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $phone    = $_POST['phone'];  // 👈 Nouveau champ téléphone
    $role     = 'student'; // rôle fixé automatiquement

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $phone, $role]);
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<?php include 'nav.php'; ?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Inscription</title>
</head>
<body>
<div class="form-box">
    <h2>Inscription</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Nom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Téléphone" required> <!-- 👈 Ajout ici -->
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
</div>
</body>
</html>
