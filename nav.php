<nav class="navbar">
        <div class="logo">
            <img src="logomaison.png" alt="Logo" height="40">
        </div>
        <div class="nav-links">
            <?php if (!isset($_SESSION['user'])): ?>
                <a href="login.php">Connexion</a>
                <a href="register.php">Inscription</a>
            <?php else: ?>
                <span>Bonjour, <?= htmlspecialchars($_SESSION['user']['name']); ?></span>
                <a href="logout.php">Déconnexion</a>
            <?php endif; ?>
        </div>
    </nav>