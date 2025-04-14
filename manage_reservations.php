<?php
include 'config.php';
session_start();

// Vérifier si l'utilisateur est connecté et est un propriétaire
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'owner') {
    header('Location: login.php');
    exit;
}

// Supprimer une réservation si le paramètre 'delete' est défini dans l'URL
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Supprimer les paiements associés à cette réservation
    $stmt = $pdo->prepare("DELETE FROM payments WHERE reservation_id = ?");
    $stmt->execute([$delete_id]);

    // Supprimer la réservation dans la base de données
    $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$delete_id]);

    // Rediriger pour recharger la page après la suppression
    header("Location: manage_reservations.php");
    exit;
}

// Récupérer les réservations depuis la base de données
$reservations = $pdo->query("SELECT * FROM reservations")->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si les réservations existent
if ($reservations) {
    // Récupérer les informations des étudiants
    $student_ids = array_column($reservations, 'student_id');
    $students = $pdo->query("SELECT id, name FROM users WHERE id IN (" . implode(',', $student_ids) . ")")->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les informations des maisons
    $house_ids = array_column($reservations, 'house_id');
    $houses = $pdo->query("SELECT id, title FROM houses WHERE id IN (" . implode(',', $house_ids) . ")")->fetchAll(PDO::FETCH_ASSOC);

    // Fusionner les données
    foreach ($reservations as &$reservation) {
        // Récupérer le nom de l'étudiant
        $reservation['student_name'] = current(array_filter($students, fn($student) => $student['id'] === $reservation['student_id']))['name'];
        
        // Récupérer le nom de la maison
        $reservation['house_name'] = current(array_filter($houses, fn($house) => $house['id'] === $reservation['house_id']))['title'];
    }
} else {
    echo "Aucune réservation trouvée.";
    exit;
}
?>
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les réservations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'nav.php'; ?>
<div class="container">
    <!-- Retour button -->
    <button onclick="history.back()" class="btn-return">Retour</button>
    
    <h2>Liste des réservations</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Étudiant</th>
                <th>Logement</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $res): ?>
            <tr>
                <td><?= $res['id'] ?></td>
                <td><?= htmlspecialchars($res['student_name']) ?></td>
                <td><?= htmlspecialchars($res['house_name']) ?></td>
                <td><?= $res['start_date'] ?></td>
                <td><?= $res['end_date'] ?></td>
                <td>
                    <!-- Le lien pour supprimer la réservation -->
                    <a href="?delete=<?= $res['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
