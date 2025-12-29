<?php

require_once __DIR__ . '/Card.php';

class Deck
{
    public static function generate(int $pairs): array
    {
        $cards = [];

        for ($i = 1; $i <= $pairs; $i++) {
            // 2 cartes pour la même valeur
            $cards[] = new Card(uniqid('', true), $i);
            $cards[] = new Card(uniqid('', true), $i);
        }

        shuffle($cards);

        return $cards;
    }
}
