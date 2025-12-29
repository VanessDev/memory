<?php
session_start();

require_once __DIR__ . '/classes/Game.php';
require_once __DIR__ . '/classes/Player.php';

if (!isset($_SESSION['game'], $_SESSION['player_id'])) {
    header('Location: index.php');
    exit;
}

/** @var Game $game */
$game = $_SESSION['game'];

// Efface les 2 cartes non correspondantes de l'ancien tour
$game->clearMismatched();

if (isset($_GET['flip'])) {
    $index = (int)$_GET['flip'];
    $game->flipCard($index);

    if ($game->isFinished()) {
        $score = $game->getScore();
        $playerId = (int)$_SESSION['player_id'];

        Player::saveScore($playerId, $game->pairs, $game->moves, $score);

        $_SESSION['last_score'] = [
            'moves' => $game->moves,
            'pairs' => $game->pairs,
            'score' => $score
        ];

        unset($_SESSION['game']); // partie terminée
        header('Location: finish.php');
        exit;
    }

    // On sauvegarde l'état mis à jour de la partie
    $_SESSION['game'] = $game;
    // Redirection pour éviter le re-submit
    header('Location: game.php');
    exit;
}

$username = $_SESSION['username'] ?? 'Joueur';
$cards = $game->cards;
$totalCards = count($cards);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Memory - Partie</title>
    <style>
        body { font-family: Arial, sans-serif; background:#e0f0ff; }
        .container { max-width:900px; margin:30px auto; background:#fff; padding:20px; border-radius:8px; }
        .grid {
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap:10px;
        }
        .card {
            height:80px;
            border-radius:6px;
            border:1px solid #ccc;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            cursor:pointer;
            user-select:none;
        }
        .card.back { background:#333; color:#333; }
        .card.front { background:#fffae6; }
        .card.found { background:#c8ffc8; }
        .top-bar { display:flex; justify-content:space-between; margin-bottom:10px; }
        a { text-decoration:none; }
    </style>
</head>
<body>
<div class="container">
    <div class="top-bar">
        <div>
            <strong><?= htmlspecialchars($username) ?></strong> |
            Coups : <?= $game->moves ?> |
            Paires trouvées : <?= $game->foundPairs ?>/<?= $game->pairs ?>
        </div>
        <div>
            <a href="index.php">Abandonner / Recommencer</a> |
            <a href="profile.php">Mon profil</a>
        </div>
    </div>

    <div class="grid">
        <?php foreach ($cards as $index => $card): ?>
            <?php
            $isFlipped = in_array($index, $game->flipped, true);
            $classes = 'card';

            if ($card->isFound) {
                $classes .= ' found front';
            } elseif ($isFlipped) {
                $classes .= ' front';
            } else {
                $classes .= ' back';
            }
            ?>
            <?php if (!$card->isFound && !$isFlipped && count($game->flipped) < 2): ?>
                <a href="game.php?flip=<?= $index ?>" class="<?= $classes ?>">
                    ?
                </a>
            <?php else: ?>
                <div class="<?= $classes ?>">
                    <?= ($card->isFound || $isFlipped) ? $card->value : '' ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
