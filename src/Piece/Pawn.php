<?php

/**
 * Classe Pawn
 * 
 * Représente le pion et gère ses règles de déplacement spécifiques.
 */

class Pawn extends Piece{
    public function __construct(PieceColor $color, Position $position) {
        parent::__construct($color, $position);
        $this->type=PieceType::PAWN;
    }
    public function isValidMovementShape(Position $target): bool
    {
        // ont se base se le fait que la grille commence en A.1 => 0;0
        $rowDepart = $this->position->getRow();
        $columnDepart = $this->position->getColumn();
        $rowArrive = $target->getRow();
        $colArrive = $target->getColumn();

        // Blanc +1
        // Noirs -1
        $direction = ($this->color === PieceColor::WHITE) ? -1 : 1;
        $startRow = ($this->color === PieceColor::WHITE) ? 6 : 1;

        $distanceRow = $rowArrive - $rowDepart;
        $distanceCol = abs($colArrive - $columnDepart);

        // Avance droit
        if ($distanceCol === 0) {
            // Avance +1
            if ($distanceRow === $direction) {
                return true;
            }
            // Avance +2
            if ($rowDepart === $startRow && $distanceRow === (2 * $direction)) {
                return true;
            }
        }

        // 2. Diagonale
        if ($distanceCol === 1 && $distanceRow === $direction) {
            return true;
        }

        throw new InvalidMoveException();
    }
}
