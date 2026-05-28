<?php
namespace App\Piece;

use App\Position;
use App\Move;
use App\Enum\PieceColor;
use App\Enum\PieceType;


/**
 * Classe Knight
 * 
 * Représente le cavalier et gère ses règles de déplacement spécifiques.
 */


class Knight extends Piece{
    public function __construct(PieceColor $color, Position $position) {
        parent::__construct($color, $position);
        $this->type=PieceType::KNIGHT;
    }
    public function isValidMovementShape(Position $target): bool
    {
        $rowDepart=$this->position->getRow();
        $columnDepart=$this->position->getColumn();

        $rowArrive=$target->getRow();
        $columnArrive=$target->getColumn();

        $distanceRow=abs($rowArrive-$rowDepart);
        $distanceColumn=abs($columnArrive-$columnDepart);


        // toujours avancer en 2|1 ou 1|2
        return ($distanceRow==2 && $distanceColumn==1) || ($distanceRow==1 && $distanceColumn==2);

    }
}