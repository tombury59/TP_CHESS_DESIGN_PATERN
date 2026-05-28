<?php
namespace App\Factory;

use App\Position;
use App\Piece\Piece;
use App\Piece\Pawn;
use App\Piece\Rook;
use App\Piece\Knight;
use App\Piece\Bishop;
use App\Piece\Queen;
use App\Piece\King;
use App\Enum\PieceColor;
use App\Enum\PieceType;
use App\Exception\InvalidPieceTypeException;


/**
 * Classe PieceFactory
 * 
 * Fabrique des pièces d'échecs.
 */
class PieceFactory{

    /**
     * Crée une pièce d'échecs.
     *
     * @param PieceType $type
     * @param PieceColor $color
     * @param Position $position
     * @return Piece
     */
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