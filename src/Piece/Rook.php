<?php
namespace App\Piece;

use App\Position;
use App\Move;
use App\Enum\PieceColor;
use App\Enum\PieceType;


/**
 * Classe Rook
 * 
 * Représente la tour et gère ses règles de déplacement spécifiques.
 */
class Rook extends Piece{
    public function __construct(PieceColor $color, Position $position) {
        parent::__construct($color, $position);
        $this->type=PieceType::ROOK;
    }
    public function isValidMovementShape(Position $target): bool
    {
        $rowDepart=$this->position->getRow();
        $columnDepart=$this->position->getColumn();

        $rowArrive=$target->getRow();
        $columnArrive=$target->getColumn();

        // ligne ou colonne only
        return !($rowDepart!=$rowArrive && $columnDepart!=$columnArrive);

    }
}