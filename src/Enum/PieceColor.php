<?php

/**
 * Enum PieceColor
 * 
 * Représente les couleurs des pièces aux échecs.
 */
enum PieceColor{

    case WHITE;
    case BLACK;

    public function opposite(): PieceColor{
        return $this === self::WHITE ? self::BLACK : self::WHITE;
    }
}