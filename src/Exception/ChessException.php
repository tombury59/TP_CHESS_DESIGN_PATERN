<?php

/**
 * Exception personnalisée pour le jeu d'échecs.
 */

class ChessException extends Exception {
    public function __construct(string $message = "Une erreur de jeu est survenue") {
        parent::__construct($message);
    }
}