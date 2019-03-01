<?php

namespace Game\War\Package;

use Game\War\Card\CardInterface;
use Game\War\Card\ClassicCard;
use Game\War\Card\NumberCard;

class Package
{
    const TYPES = ['classic', 'number'];

    /**
     * @var CardInterface[]
     */
    private $cards;

    public function __construct($type = 'classic')
    {
        $this->cards = [];

        if (!in_array($type, self::TYPES)) {
            throw new \InvalidArgumentException();
        }

        if ($type === 'classic') {
            foreach (ClassicCard::getFamiliesName() as $family) {
                foreach (ClassicCard::CARDS_MAP as $name => $value) {
                    $this->cards[] = new ClassicCard($name, $family);
                }
            }
        } elseif ($type === 'number') {
            for ($i = 1; $i < 53; $i++) {
                $this->cards[] = new NumberCard($i);
            }
        }

        shuffle($this->cards);
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}