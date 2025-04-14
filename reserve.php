<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Barre de navigation -->
    <div class="navbar">
        <div class="logo">
            <a href="dashboard.php"><img src="logo.png" alt="Logo"></a>
        </div>
        <div class="nav-links">
            <a href="dashboard.php">Tableau de bord</a>
            <a href="logout.php">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <div class="form-box">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $house_id = $_POST['house_id'];
                $start = $_POST['start_date'];
                $end = $_POST['end_date'];
                $student_id = $_SESSION['user']['id'];

                try {
                    $stmt = $pdo->prepare("INSERT INTO reservations (student_id, house_id, start_date, end_date) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$student_id, $house_id, $start, $end]);

                    echo '<div class="message-success">✅ Demande de réservation envoyée avec succès.</div>';
                } catch (PDOException $e) {
                    echo '<div class="message-error">❌ Une erreur est survenue : ' . htmlspecialchars($e->getMessage()) . '</div>';
                }

                echo '<a href="dashboard.php">⬅ Retour au tableau de bord</a>';
            } else {
                echo '<div class="message-error">Méthode non autorisée.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
