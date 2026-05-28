<?php

require_once __DIR__ . '/ChessException.php';
/**
 * Exception levée lorsqu'on essaie de déplacer une pièce adverse.
 */
class WrongTurnException extends ChessException{

    public function __construct(string $message = "Ce n'est pas votre tour de jouer !")
    {
        parent::__construct($message);
    }
}