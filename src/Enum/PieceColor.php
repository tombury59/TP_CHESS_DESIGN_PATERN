<?php
namespace App\Enum;

use App\Piece\Piece;


/**
 * Enum PieceColor
 * 
 * Représente les couleurs des pièces aux échecs.
 */
enum PieceColor{

    case WHITE;
    case BLACK;

    /**
     * Retourne la couleur opposée
     */
    public function opposite(): PieceColor{
        return $this === self::WHITE ? self::BLACK : self::WHITE;
    }
}