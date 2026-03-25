<?php

require_once __DIR__ . '/../Position.php';
require_once __DIR__ . '/Piece.php';
require_once __DIR__ . '/../Enum/PieceColor.php';
require_once __DIR__ . '/../Enum/PieceType.php';

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
$position=new Position(7,7);

$positionArrive=new Position(5,6);

$knight=new Knight(PieceColor::WHITE,$position);
var_dump($knight->isValidMovementShape($positionArrive));