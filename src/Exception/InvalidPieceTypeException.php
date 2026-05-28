<?php
namespace App\Exception;

/**
 * Exception levée lorsque le type de pièce est invalide.
 */

class InvalidPieceTypeException extends ChessException
{
    public function __construct(string $message = "Type de pièce invalide !") {
        parent::__construct($message);
    }
}