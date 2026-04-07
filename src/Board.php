<?php

require_once __DIR__ . '/Factory/PieceFactory.php';
require_once __DIR__ . '/Exception/NoPieceException.php';
require_once __DIR__ . '/Exception/InvalidPieceTypeException.php';
require_once __DIR__ . '/Contract/InterfaceBoard.php';
require_once __DIR__ . '/Exception/InvalidMoveException.php';

class Board implements InterfaceBoard {
    
    private array $pieces = [];

    public function placePiece(Piece $piece): void{
        $position=$piece->getPosition();
        $this->pieces[$position->toKey()]=$piece;
        //var_dump($this->pieces);
    }
    public function getPieceAt(Position $position): ?Piece{
        $key = $position->toKey();
        if (isset($this->pieces[$key])) {
            return $this->pieces[$key];
        }
        return null;
        //return $this->getPieces()[$position->toKey()];
    }
    public function hasPieceAt(Position $position): bool{
        //return isset($this->getPieces()[$position->toKey()]);
        return isset($this->pieces[$position->toKey()]);
    }
    public function removePieceAt(Position $position): void{
        unset($this->pieces[$position->toKey()]);
    }
    public function movePiece(Position $from, Position $to): void {
        $piece = $this->getPieceAt($from);
        if ($piece === null) {
            throw new NoPieceException();
        }

        $this->removePieceAt($from);
        // var_dump($this->pieces);
        
        $piece->setPosition($to);
        
        $this->placePiece($piece);
    }
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

    public function getPieces(): array{

        return $this->pieces;
    }
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

    public function render(): string {
        // fait par iA
        $out = "\n    0  1  2  3  4  5  6  7\n"; // Coordonnées du haut
        $out .= "  +------------------------+\n";

        for ($r = 0; $r <= 7; $r++) {
            $out .= $r . " |"; // Indice de ligne
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
            $out .= "| " . $r . "\n"; // Indice de ligne à droite aussi
        }

        $out .= "  +------------------------+\n";
        $out .= "    0  1  2  3  4  5  6  7\n";
        return $out;
    }

}

//$factory = new PieceFactory();
//$board = new Board();
//
//$whiteKing = $factory->create(PieceType::KING, PieceColor::WHITE, new Position(7, 4));
//$board->placePiece($whiteKing);
//
//$blackQueen = $factory->create(PieceType::QUEEN, PieceColor::BLACK, new Position(0, 3));
//$board->placePiece($blackQueen);
//
//echo $board->render();
