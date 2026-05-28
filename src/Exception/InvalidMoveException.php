<?php

require_once __DIR__ . '/ChessException.php';

/**
 * Exception levée lorsque le mouvement est invalide.
 */
class InvalidMoveException extends ChessException{

    public function __construct(string $message = "Mouvement invalide pour cette pièce !")
    {
        parent::__construct($message);
    }
}