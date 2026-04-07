<?php

require_once __DIR__ . '/ChessException.php';
class WrongTurnException extends ChessException{

    public function __construct(string $message = "Ce n'est pas votre tour de jouer !")
    {
        parent::__construct($message);
    }
}