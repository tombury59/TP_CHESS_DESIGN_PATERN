<?php

class InvalidPieceTypeException extends Exception
{
    public function __construct() {
        parent::__construct("Type de pièce invalide !");
    }
}