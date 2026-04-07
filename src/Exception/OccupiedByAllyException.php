<?php
require_once __DIR__ . '/ChessException.php';
class OccupiedByAllyException extends ChessException
{
    public function __construct(string $message = "La case cible est occupée par une pièce alliée !")
    {
        parent::__construct($message);
    }
}