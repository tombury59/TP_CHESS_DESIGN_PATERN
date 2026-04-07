<?php
require_once __DIR__ . '/ChessException.php';
class NoPieceException extends ChessException
{
    public function __construct(string $message = "Aucune pièce à cette position !")
    {
        parent::__construct($message);
    }
}