<?php
require_once __DIR__ . '/../Piece/Piece.php';
require_once __DIR__ . '/../Piece/Pawn.php';
require_once __DIR__ . '/../Piece/Rook.php';
require_once __DIR__ . '/../Piece/Knight.php';
require_once __DIR__ . '/../Piece/Bishop.php';
require_once __DIR__ . '/../Piece/Queen.php';
require_once __DIR__ . '/../Piece/King.php';
require_once __DIR__ . '/../Enum/PieceColor.php';
require_once __DIR__ . '/../Enum/PieceType.php';
class PieceFactory{

    public function create(PieceType $type, PieceColor $color, Position $position): Piece
    {
        switch ($type) {
            case PieceType::PAWN:
                return new Pawn($color, $position);
            case PieceType::ROOK:
                return new Rook($color, $position);
            case PieceType::KNIGHT:
                return new Knight($color, $position);
            case PieceType::BISHOP:
                return new Bishop($color, $position);
            case PieceType::QUEEN:
                return new Queen($color, $position);
            case PieceType::KING:
                return new King($color, $position);
            default:
                throw new InvalidPieceTypeException();
        }
    }
}