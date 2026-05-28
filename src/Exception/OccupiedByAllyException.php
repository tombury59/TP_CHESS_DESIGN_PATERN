<?php
namespace App\Exception;


/**
 * Exception levée lorsqu'une case est occupée par une pièce alliée.
 */
class OccupiedByAllyException extends ChessException
{
    public function __construct(string $message = "La case cible est occupée par une pièce alliée !")
    {
        parent::__construct($message);
    }
}