<?php

class WrongTurnException extends Exception{

    public function __construct()
    {
        parent::__construct("Ce n'est pas votre tour de jouer !");
    }
}