<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user'])) header('Location: login.php');
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<?php include 'nav.php'; ?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="dashboard-box">
    <h2>Tableau de bord</h2>
    <p>Bienvenue, <strong><?= htmlspecialchars($user['name']); ?></strong> (<?= htmlspecialchars($user['role']); ?>)</p>
    

    <?php if ($user['role'] === 'owner'): ?>
        <a href="add_house.php">Ajouter un logement</a>
        <a href="manage_users.php">manager users</a>
        <a href="manage_houses.php">Gérer les logements</a>
<a href="manage_reservations.php">Gérer les réservations</a>
    <?php elseif ($user['role'] === 'student'): ?>
        <a href="houses.php">Voir les logements disponibles</a>
    <?php endif; ?>
</div>

</body>
</html>
