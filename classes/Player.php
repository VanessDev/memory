<?php

require_once __DIR__ . '/DB.php';

class Player
{
    public int $id;
    public string $username;

    public function __construct(int $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public static function findOrCreate(string $username): Player
    {
        $pdo = DB::getConnection();

        // On cherche le joueur
        $stmt = $pdo->prepare("SELECT id, username FROM players WHERE username = :u");
        $stmt->execute(['u' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Player((int)$row['id'], $row['username']);
        }

        // Sinon on le crée
        $stmt = $pdo->prepare("INSERT INTO players (username) VALUES (:u)");
        $stmt->execute(['u' => $username]);

        $id = (int)$pdo->lastInsertId();
        return new Player($id, $username);
    }

    public static function getTopScores(int $limit = 10): array
    {
        $pdo = DB::getConnection();
        $sql = "SELECT p.username, s.score, s.moves, s.pairs, s.created_at
                FROM scores s
                JOIN players p ON p.id = s.player_id
                ORDER BY s.score ASC
                LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getScoresForPlayer(int $playerId): array
    {
        $pdo = DB::getConnection();
        $sql = "SELECT score, moves, pairs, created_at
                FROM scores
                WHERE player_id = :id
                ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $playerId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function saveScore(int $playerId, int $pairs, int $moves, float $score): void
    {
        $pdo = DB::getConnection();
        $stmt = $pdo->prepare(
            "INSERT INTO scores (player_id, pairs, moves, score) 
             VALUES (:pid, :pairs, :moves, :score)"
        );
        $stmt->execute([
            'pid'   => $playerId,
            'pairs' => $pairs,
            'moves' => $moves,
            'score' => $score,
        ]);
    }
}
