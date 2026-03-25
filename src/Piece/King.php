<?php

//require_once __DIR__ . '/../Position.php';
//require_once __DIR__ . '/Piece.php';
//require_once __DIR__ . '/../Enum/PieceColor.php';
//require_once __DIR__ . '/../Enum/PieceType.php';

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

        // distance cases adjacentes max == 1
        return $distanceColumn<=1 && $distanceRow<=1;

    }
}
//$position=new Position(7,7);
//
//$positionArrive=new Position(7,7);

//$king=new King(PieceColor::WHITE,$position);
//var_dump($king->isValidMovementShape($positionArrive));