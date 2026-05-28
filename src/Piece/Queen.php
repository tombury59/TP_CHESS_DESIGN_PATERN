<?php
namespace App\Piece;

use App\Position;
use App\Move;
use App\Enum\PieceColor;
use App\Enum\PieceType;


/**
 * Classe Queen
 * 
 * Représente la dame et gère ses règles de déplacement spécifiques.
 */


class Queen extends Piece{
    public function __construct(PieceColor $color, Position $position) {
        parent::__construct($color, $position);
        $this->type=PieceType::QUEEN;
    }
    public function isValidMovementShape(Position $target): bool
    {
        $rowDepart=$this->position->getRow();
        $columnDepart=$this->position->getColumn();

        $rowArrive=$target->getRow();
        $columnArrive=$target->getColumn();

        $distanceRow=abs($rowArrive-$rowDepart);
        $distanceColumn=abs($columnArrive-$columnDepart);

        // mélange de Bishop et Rook
        return $distanceRow==$distanceColumn || !($rowDepart!=$rowArrive && $columnDepart!=$columnArrive);

    }
}