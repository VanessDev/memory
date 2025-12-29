<?php
// classes/Game.php
require_once __DIR__ . '/Deck.php';

class Game
{
    public array $cards = [];   
    public int $moves = 0;
    public int $pairs;
    public int $foundPairs = 0;
    public array $flipped = [];   

    public function __construct(int $pairs)
    {
        $this->pairs = $pairs;
        $this->cards = Deck::generate($pairs);
    }

    public function flipCard(int $index): void
    {
        if (!isset($this->cards[$index])) {
            return;
        }

        // Carte déjà trouvée => inutile
        if ($this->cards[$index]->isFound) {
            return;
        }

        // déjà retournée ?
        if (in_array($index, $this->flipped)) {
            return;
        }

        // max 2 cartes à la fois
        if (count($this->flipped) >= 2) {
            return;
        }

        $this->flipped[] = $index;

        // si 2 cartes => on compte un coup et on teste la paire
        if (count($this->flipped) === 2) {
            $this->moves++;

            [$i, $j] = $this->flipped;
            $card1 = $this->cards[$i];
            $card2 = $this->cards[$j];

            if ($card1->value === $card2->value) {
                $card1->isFound = true;
                $card2->isFound = true;
                $this->foundPairs++;
                // On laisse flipped vide pour ne plus les afficher comme "en test"
                $this->flipped = [];
            }
        }
    }

    // À appeler à chaque début de tour pour effacer les 2 cartes non correspondantes
    public function clearMismatched(): void
    {
        if (count($this->flipped) === 2) {
            $i = $this->flipped[0];
            $j = $this->flipped[1];
            if ($this->cards[$i]->value !== $this->cards[$j]->value) {
                $this->flipped = [];
            }
        }
    }

    public function isFinished(): bool
    {
        return $this->foundPairs >= $this->pairs;
    }

    public function getScore(): float
    {
        if ($this->pairs === 0) {
            return 0.0;
        }
        return round($this->moves / $this->pairs, 2);
    }
}
