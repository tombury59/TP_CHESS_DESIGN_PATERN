<?php
namespace App;
use App\Position;
use App\Move;

/**
 * Classe Move
 * 
 * Représente un mouvement d'une position de départ vers une position d'arrivée.
 */
class Move{
    private Position $from;
    private Position $to;

    /**
     * @param Position $from
     * @param Position $to
     */
    public function __construct(Position $from, Position $to)
    {
        $this->from=$from;
        $this->to=$to;
    }
    /**
     * @return Position
     */
    public function getFrom(): Position{
        return $this->from;
    }

    /**
     * @return Position
     */
    public function getTo(): Position{
        return $this->to;
    }
}
