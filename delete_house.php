<?php
include 'config.php';
session_start();

// Vérifier si l'utilisateur est connecté et est un propriétaire
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'owner') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $house_id = $_GET['id'];

    // Récupérer les informations du logement à supprimer
    $stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ?");
    $stmt->execute([$house_id]);
    $house = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($house) {
        // Afficher un message de confirmation
        // HTML structure
        echo "<!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='styles.css'>
            <title>Confirmation de suppression</title>
        </head>
        <body>
            <div class='form-box'>
                <h2>Êtes-vous sûr de vouloir supprimer ce logement ?</h2>
                <p><strong>Nom du logement :</strong> " . htmlspecialchars($house['title']) . "</p>
                <p><strong>Adresse :</strong> " . htmlspecialchars($house['address']) . "</p>
                <p><strong>Prix :</strong> " . htmlspecialchars($house['price']) . " MAD</p>
                <div class='buttons'>
                    <a href='manage_houses.php?id=" . $house_id . "&confirm=true' class='btn-confirm'>Confirmer la suppression</a> | 
                    <a href='manage_houses.php' class='btn-cancel'>Annuler</a>
                </div>
            </div>
        </body>
        </html>";
    } else {
        echo "Le logement n'existe pas.";
        exit;
    }
} elseif (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    // Confirmer la suppression du logement
    if (isset($_GET['id'])) {
        $house_id = $_GET['id'];
        
        // Supprimer le logement de la base de données
        $stmt = $pdo->prepare("DELETE FROM houses WHERE id = ?");
        $stmt->execute([$house_id]);

        // Rediriger vers la page de gestion des logements
        header("Location: manage_houses.php");
        exit;
    }
} else {
    echo "ID du logement manquant.";
    exit;
}
?>
