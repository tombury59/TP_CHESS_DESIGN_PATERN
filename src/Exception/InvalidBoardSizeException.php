<?php
namespace App\Exception;

/**
 * Exception levée lorsque la taille du plateau est invalide.
 */
class InvalidBoardSizeException extends ChessException
{
    public function __construct(string $message = "La taille du plateau doit être de 8x8 !")
    {
        parent::__construct($message);
    }
}