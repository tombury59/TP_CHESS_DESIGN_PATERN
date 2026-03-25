<?php

class InvalidBoardSizeException extends Exception
{
    public function __construct()
    {
        parent::__construct("La taille du plateau doit être de 8x8 !");
    }
}