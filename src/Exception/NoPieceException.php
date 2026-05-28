<?php
require_once __DIR__ . '/ChessException.php';
/**
 * Exception levée lorsqu'il n'y a pas de pièce à une position donnée.
 */
class NoPieceException extends ChessException
{
    public function __construct(string $message = "Aucune pièce à cette position !")
    {
        parent::__construct($message);
    }
}