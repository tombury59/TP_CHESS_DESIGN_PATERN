<?php

require_once __DIR__ . '/ChessException.php';
class InvalidBoardSizeException extends ChessException
{
    public function __construct(string $message = "La taille du plateau doit être de 8x8 !")
    {
        parent::__construct($message);
    }
}