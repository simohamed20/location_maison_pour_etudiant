<?php include 'config.php'; session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'owner') header('Location: login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $addr = $_POST['address'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $owner = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("INSERT INTO houses (owner_id, title, description, address, city, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$owner, $title, $desc, $addr, $city, $price]);
    echo "Logement ajouté avec succès.";
}
?>
<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="POST">
    <h2>Ajouter un logement</h2>
    Titre: <input type="text" name="title" required><br>
    Description: <textarea name="description"></textarea><br>
    Adresse: <input type="text" name="address" required><br>
    Ville: <input type="text" name="city" required><br>
    Prix: <input type="number" step="0.01" name="price" required><br>
    <button type="submit">Ajouter</button>
</form>
</body>
</html>
