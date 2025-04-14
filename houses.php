<?php include 'config.php'; session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM houses WHERE available = 1 ORDER BY id DESC");
$houses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<?php include 'nav.php'; ?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Maisons et Studios Étudiants</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Logements disponibles pour étudiants</h2>
        <?php foreach ($houses as $house): ?>
            <div class="house">
                <h3><?= htmlspecialchars($house['title']); ?> – <?= number_format($house['price'], 2) ?> DH</h3>
                <p><strong>Ville :</strong> <?= htmlspecialchars($house['city']); ?></p>
                <p><?= htmlspecialchars($house['description']); ?></p>
                <p><strong>Adresse :</strong> <?= htmlspecialchars($house['address']); ?></p>
                <form method="POST" action="reserve.php">
                    <input type="hidden" name="house_id" value="<?= $house['id']; ?>">
                    Date début: <input type="date" name="start_date" required>
                    Date fin: <input type="date" name="end_date" required>
                    <button type="submit">Réserver ce logement</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
