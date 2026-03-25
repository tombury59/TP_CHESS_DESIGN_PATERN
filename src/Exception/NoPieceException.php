<?php

class NoPieceException extends Exception
{
    public function __construct()
    {
        parent::__construct("Aucune pièce à cette position !");
    }
}