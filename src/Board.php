<?php
namespace App;
use App\Position;
use App\Board;
use App\Piece\Piece;
use App\Piece\King;
use App\Enum\PieceColor;
use App\Enum\PieceType;
use App\Contract\InterfaceBoard;
use App\Exception\NoPieceException;


/**
 * Classe Board
 * 
 * Représente le plateau de jeu d'échecs.
 * Gère l'état des cases et les positions des pièces.
 */
class Board implements InterfaceBoard {
    
    private array $pieces = [];

    /**
     * Place une pièce sur le plateau à sa position.
     *
     * @param Piece $piece La pièce à placer
     */
    public function placePiece(Piece $piece): void{
        $position=$piece->getPosition();
        $this->pieces[$position->toKey()]=$piece;
    }
    /**
     * Récupère la pièce située à une position donnée.
     *
     * @param Position $position Coordonnées
     * @return Piece|null La pièce ou null si case vide
     */
    public function getPieceAt(Position $position): ?Piece{
        $key = $position->toKey();
        if (isset($this->pieces[$key])) {
            return $this->pieces[$key];
        }
        return null;
    }
    /**
     * Vérifie si une pièce est présente à une position donnée.
     *
     * @param Position $position
     * @return bool
     */
    public function hasPieceAt(Position $position): bool{
        return isset($this->pieces[$position->toKey()]);
    }

    /**
     * Supprime la pièce située à la position donnée.
     *
     * @param Position $position
     */
    public function removePieceAt(Position $position): void{
        unset($this->pieces[$position->toKey()]);
    }

    /**
     * Déplace une pièce d'une position à une autre sur le plateau.
     *
     * @param Position $from
     * @param Position $to
     * @throws NoPieceException
     */
    public function movePiece(Position $from, Position $to): void {
        $piece = $this->getPieceAt($from);
        if ($piece === null) {
            throw new NoPieceException();
        }

        $this->removePieceAt($from);

        $piece->setPosition($to);
        
        $this->placePiece($piece);
    }
    /**
     * Vérifie si le chemin est libre entre deux positions (horizontal, vertical, diagonale).
     *
     * @param Position $from
     * @param Position $to
     * @return bool True si aucun obstacle, False sinon
     */
    public function isPathClear(Position $from, Position $to): bool {
        $dfRow = $to->getRow() - $from->getRow();
        $dfCol = $to->getColumn() - $from->getColumn();

        $stepRow = ($dfRow === 0) ? 0 : $dfRow / abs($dfRow);
        $stepCol = ($dfCol === 0) ? 0 : $dfCol / abs($dfCol);

        $currRow = $from->getRow() + $stepRow;
        $currCol = $from->getColumn() + $stepCol;

        while ($currRow != $to->getRow() || $currCol != $to->getColumn()) {
            if ($this->hasPieceAt(new Position((int)$currRow, (int)$currCol))) {
                return false;
            }
            $currRow += $stepRow;
            $currCol += $stepCol;
        }
        
        return true;
    }

    /**
     * Retourne toutes les pièces présentes sur le plateau.
     *
     * @return array<string, Piece>
     */
    public function getPieces(): array{

        return $this->pieces;
    }

    /**
     * Récupère la position du Roi de la couleur spécifiée.
     *
     * @param PieceColor $color
     * @return Position|null
     */
    public function getKingPosition(PieceColor $color): ?Position
    {
        $pieces = $this->getPieces();
        foreach ($pieces as $piece) {
            if ($piece->getColor() == $color && $piece->getType() === PieceType::KING) {
                return $piece->getPosition();
            }
        }
        return null;
    }

    /**
     * Génère une représentation sous forme de chaîne du plateau (rendu ASCII).
     *
     * @return string
     */
    public function render(): string {
        // fait par iA
        $out = "\n    0  1  2  3  4  5  6  7\n";
        $out .= "  +------------------------+\n";

        for ($r = 0; $r <= 7; $r++) {
            $out .= $r . " |";
            for ($c = 0; $c <= 7; $c++) {
                $pos = new Position($r, $c);
                $p = $this->getPieceAt($pos);
                
                // Logique du damier : (ligne + colonne) pair ou impair
                $isDark = ($r + $c) % 2 !== 0;
                $bg = $isDark ? "\e[48;5;240m" : "\e[48;5;245m"; // Gris foncé vs Gris clair
                $reset = "\e[0m";

                $char = $p ? $p->render() : " ";
                
                // On ajoute des espaces pour que chaque case soit un carré de 3 persos
                $out .= $bg . " " . $char . " " . $reset;
            }
            $out .= "| " . $r . "\n";
        }

        $out .= "  +------------------------+\n";
        $out .= "    0  1  2  3  4  5  6  7\n";
        return $out;
    }

}
