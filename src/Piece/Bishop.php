<?php
namespace App\Piece;

use App\Position;
use App\Move;
use App\Enum\PieceColor;
use App\Enum\PieceType;


/**
 * Classe Bishop
 * 
 * Représente le fou et gère ses règles de déplacement spécifiques.
 */
class Bishop extends Piece{
    public function __construct(PieceColor $color, Position $position) {
        parent::__construct($color, $position);
        $this->type=PieceType::BISHOP;
    }
    public function isValidMovementShape(Position $target): bool
    {
        $rowDepart=$this->position->getRow();
        $columnDepart=$this->position->getColumn();

        $rowArrive=$target->getRow();
        $columnArrive=$target->getColumn();

        $distanceRow=abs($rowArrive-$rowDepart);
        $distanceColumn=abs($columnArrive-$columnDepart);

        // diagonal only
        return $distanceRow==$distanceColumn;

    }
}