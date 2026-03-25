<?php

class InvalidMoveException extends Exception{

    public function __construct()
    {
        parent::__construct("Mouvement invalide pour cette pièce !");
    }
}