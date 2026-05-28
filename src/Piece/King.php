<?php
namespace App\Piece;

use App\Position;
use App\Move;
use App\Enum\PieceColor;
use App\Enum\PieceType;


/**
 * Classe King
 * 
 * Représente le roi et gère ses règles de déplacement spécifiques, y compris le roque.
 */
class King extends Piece{
    public function __construct(PieceColor $color, Position $position) {
        parent::__construct($color, $position);
        $this->type=PieceType::KING;
    }
    public function isValidMovementShape(Position $target): bool
    {
        $rowDepart=$this->position->getRow();
        $columnDepart=$this->position->getColumn();

        $rowArrive=$target->getRow();
        $columnArrive=$target->getColumn();

        $distanceRow=abs($rowArrive-$rowDepart);
        $distanceColumn=abs($columnArrive-$columnDepart);

        $oneCaseMove = ($distanceColumn<=1 && $distanceRow<=1);
        $rockMove = (!$this->hasMoved() && $distanceRow === 0 && $distanceColumn === 2);

        // distance cases adjacentes max == 1
        return $oneCaseMove || $rockMove;

    }
}