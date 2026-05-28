<?php
require_once __DIR__ . '/ChessException.php';
/**
 * Exception levée lorsqu'on essaie de déplacer une pièce sur la même case.
 */
class SameTileException extends ChessException{

    public function __construct(string $message = "Vous devez bouger la pièce vers une autre case !")
    {
        parent::__construct($message);
    }
}
