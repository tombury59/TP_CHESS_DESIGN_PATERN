<?php
/**
 * Interface Renderable
 * 
 * Représente un objet qui peut être rendu sous forme de chaîne de caractères.
 */
interface Renderable{
    public function render(): string;
}