<?php
session_start();

require_once __DIR__ . '/classes/Player.php';

if (!isset($_SESSION['player_id'])) {
    header('Location: index.php');
    exit;
}

$playerId = (int)$_SESSION['player_id'];
$username = $_SESSION['username'] ?? 'Joueur';

$scores = Player::getScoresForPlayer($playerId);

$bestScore = null;
foreach ($scores as $s) {
    if ($bestScore === null || $s['score'] < $bestScore) {
        $bestScore = $s['score'];
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Memory - Profil</title>
    <style>
        body { font-family: Arial, sans-serif; background:#eef; }
        .container { max-width:800px; margin:30px auto; background:#fff; padding:20px; border-radius:8px; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { border:1px solid #ddd; padding:8px; text-align:center; }
        th { background:#eee; }
        .links { margin-top:20px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Profil de <?= htmlspecialchars($username) ?></h1>

    <p>Nombre de parties jouées : <?= count($scores) ?></p>
    <p>Meilleur score : <?= $bestScore !== null ? $bestScore : '—' ?></p>

    <div class="links">
        <a href="index.php">Accueil / Nouvelle partie</a>
    </div>

    <h2>Historique des scores</h2>
    <?php if (!$scores): ?>
        <p>Pas encore de partie enregistrée.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Paires</th>
                <th>Coups</th>
                <th>Score</th>
            </tr>
            <?php foreach ($scores as $row): ?>
                <tr>
                    <td><?= $row['created_at'] ?></td>
                    <td><?= $row['pairs'] ?></td>
                    <td><?= $row['moves'] ?></td>
                    <td><?= $row['score'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
