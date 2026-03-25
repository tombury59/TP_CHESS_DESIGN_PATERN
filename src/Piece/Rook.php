<?php

//require_once __DIR__ . '/../Position.php';
//require_once __DIR__ . '/Piece.php';
//require_once __DIR__ . '/../Enum/PieceColor.php';
//require_once __DIR__ . '/../Enum/PieceType.php';

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
//$position=new Position(7,7);
//
//$positionArrive=new Position(5,6);
//
//$rook=new Rook(PieceColor::WHITE,$position);
//var_dump($rook->isValidMovementShape($positionArrive));