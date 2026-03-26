<?php

require_once __DIR__ . '/../Position.php';
require_once __DIR__ . '/Piece.php';
require_once __DIR__ . '/../Enum/PieceColor.php';
require_once __DIR__ . '/../Enum/PieceType.php';

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
//$position=new Position(7,7);
//
//$positionArrive=new Position(7,1);
//
//$queen=new Queen(PieceColor::WHITE,$position);
//var_dump($queen->isValidMovementShape($positionArrive));