<?php
require_once __DIR__ . '/ChessException.php';

/**
 * Exception levée lorsque le type de pièce est invalide.
 */

class InvalidPieceTypeException extends ChessException
{
    public function __construct(string $message = "Type de pièce invalide !") {
        parent::__construct($message);
    }
}