<?php

class ChessException extends Exception {
    public function __construct(string $message = "Une erreur de jeu est survenue") {
        parent::__construct($message);
    }
}