<?php
include 'config.php';
session_start();

// Vérifier si l'utilisateur est connecté et est un propriétaire
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'owner') {
    header('Location: login.php');
    exit;
}

// Récupérer la liste des logements
$stmt = $pdo->query("SELECT * FROM houses");
$houses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Logements</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="container">
    <h2>Liste des Logements</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($houses as $house): ?>
            <tr>
                <td><?= htmlspecialchars($house['id']) ?></td>
                <td><?= htmlspecialchars($house['title']) ?></td>
                <td><?= htmlspecialchars($house['address']) ?></td>
                <td><?= htmlspecialchars($house['price']) ?> MAD</td>
                <td>
                    <a href="edit_house.php?id=<?= $house['id'] ?>" class="btn-edit">Éditer</a>
                    <a href="delete_house.php?id=<?= $house['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce logement ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
