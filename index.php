<?php
session_start();

require_once __DIR__ . '/classes/Game.php';
require_once __DIR__ . '/classes/Player.php';

// Réinitialise la session de jeu
unset($_SESSION['game']);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $pairs    = (int)($_POST['pairs'] ?? 6);

    if ($username === '') {
        $error = "Merci de saisir un pseudo.";
    } elseif ($pairs < 3 || $pairs > 12) {
        $error = "Le nombre de paires doit être entre 3 et 12.";
    } else {
        // Joueur
        $player = Player::findOrCreate($username);
        $_SESSION['player_id'] = $player->id;
        $_SESSION['username']  = $player->username;

        // Partie
        $game = new Game($pairs);
        $_SESSION['game'] = $game;

        header('Location: game.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Memory - Accueil</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f2f2f2; }
        .container { max-width:600px; margin:50px auto; background:#fff; padding:20px; border-radius:8px; }
        label { display:block; margin-top:10px; }
        input, select { width:100%; padding:8px; margin-top:5px; }
        button { margin-top:15px; padding:10px 15px; cursor:pointer; }
        .error { color:red; margin-top:10px;}
        .links { margin-top:20px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Memory</h1>
    <p>Choisis ton pseudo et le nombre de paires pour commencer une partie.</p>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Pseudo :</label>
        <input type="text" name="username" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">

        <label>Nombre de paires (3 à 12) :</label>
        <select name="pairs">
            <?php for ($i = 3; $i <= 12; $i++): ?>
                <option value="<?= $i ?>" <?= (isset($pairs) && $pairs == $i) ? 'selected' : '' ?>>
                    <?= $i ?> paires (<?= $i*2 ?> cartes)
                </option>
            <?php endfor; ?>
        </select>

        <button type="submit">Lancer la partie</button>
    </form>

    <?php if (!empty($_SESSION['player_id'])): ?>
        <div class="links">
            <a href="profile.php">Voir mon profil</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
