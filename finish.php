<?php
session_start();

require_once __DIR__ . '/classes/Player.php';

if (!isset($_SESSION['last_score'], $_SESSION['player_id'])) {
    header('Location: index.php');
    exit;
}

$last = $_SESSION['last_score'];
$username = $_SESSION['username'] ?? 'Joueur';

$top10 = Player::getTopScores(10);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Memory - Résultat</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; }
        .container { max-width:800px; margin:30px auto; background:#fff; padding:20px; border-radius:8px; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { border:1px solid #ddd; padding:8px; text-align:center; }
        th { background:#eee; }
        .links { margin-top:20px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Partie terminée !</h1>

    <p><strong><?= htmlspecialchars($username) ?></strong>, voici ton résultat :</p>
    <ul>
        <li>Nombre de paires : <?= $last['pairs'] ?></li>
        <li>Nombre de coups : <?= $last['moves'] ?></li>
        <li>Score (coups / paires) : <?= $last['score'] ?></li>
    </ul>

    <div class="links">
        <a href="index.php">Relancer une partie</a> |
        <a href="profile.php">Voir mon profil</a>
    </div>

    <h2>Top 10 des meilleurs scores</h2>
    <table>
        <tr>
            <th>#</th>
            <th>Joueur</th>
            <th>Score</th>
            <th>Coups</th>
            <th>Paires</th>
            <th>Date</th>
        </tr>
        <?php foreach ($top10 as $i => $row): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['score'] ?></td>
                <td><?= $row['moves'] ?></td>
                <td><?= $row['pairs'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
