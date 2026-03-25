<?php

//require_once __DIR__ . '/../Position.php';
//require_once __DIR__ . '/Piece.php';
//require_once __DIR__ . '/../Enum/PieceColor.php';
//require_once __DIR__ . '/../Enum/PieceType.php';

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
//$position=new Position(7,7);
//
//$positionArrive=new Position(6,6);
//
//$bishop=new Bishop(PieceColor::WHITE,$position);
//var_dump($bishop->isValidMovementShape($positionArrive));