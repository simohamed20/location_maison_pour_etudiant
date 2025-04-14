<?php
include 'config.php';session_start();
// Vérifier si l'utilisateur est connecté et est un propriétaire
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'owner') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $house_id = $_GET['id'];
    
    // Récupérer les informations du logement à partir de la base de données
    $stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ?");
    $stmt->execute([$house_id]);
    $house = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le logement existe
    if (!$house) {
        echo "Le logement n'existe pas.";
        exit;
    }
} else {
    echo "ID du logement manquant.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $price = $_POST['price'];

    // Mettre à jour les informations du logement dans la base de données
    $stmt = $pdo->prepare("UPDATE houses SET name = ?, address = ?, price = ? WHERE id = ?");
    $stmt->execute([$name, $address, $price, $house_id]);

    header("Location: manage_houses.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer le Logement</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="transparent-border">
    <h2>Éditer le Logement</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Nom du Logement" value="<?= htmlspecialchars($house['title']) ?>" required>
        <input type="text" name="address" placeholder="Adresse" value="<?= htmlspecialchars($house['address']) ?>" required>
        <input type="number" name="price" placeholder="Prix (MAD)" value="<?= htmlspecialchars($house['price']) ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</div>
</body>
</html>
