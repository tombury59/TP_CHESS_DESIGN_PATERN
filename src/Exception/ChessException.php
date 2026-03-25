<?php

class ChessException extends Exception
{
    public function __construct()
    {
        parent::__construct("Une erreur est survenu  !");
    }
}