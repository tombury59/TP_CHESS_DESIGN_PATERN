<?php
require_once __DIR__ . '/ChessException.php';
class SameTileException extends ChessException{

    public function __construct(string $message = "Vous devez bouger la pièce vers une autre case !")
    {
        parent::__construct($message);
    }
}
