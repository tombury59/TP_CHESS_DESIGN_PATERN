<?php

class SameTileException extends Exception{

    public function __construct()
    {
        parent::__construct("Vous devez bouger la pièce vers une autre case !");
    }
}
