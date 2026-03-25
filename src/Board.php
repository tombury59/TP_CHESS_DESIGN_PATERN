<?php

require_once __DIR__ . '/Contract/InterfaceBoard.php';
require_once __DIR__ . '/Position.php';
require_once __DIR__ . '/Piece/Piece.php';
require_once __DIR__ . '/Piece/King.php';
require_once __DIR__ . '/Enum/PieceColor.php';
require_once __DIR__ . '/Enum/PieceType.php';
require_once __DIR__ . '/Factory/PieceFactory.php';

class Board implements InterfaceBoard {
    public array $pieces = [];
    //public function __construct($pieces)
    //{
    //    $this->
    //}

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
        if (!isset($this->pieces[$position->toKey()])) {
            throw new NoPieceException();
        }
        return true;
    }
    public function removePieceAt(Position $position): void{
        unset($this->pieces[$position->toKey()]);
    }
    public function movePiece(Position $from, Position $to): void
    {
        //$move = new Move($from,$to);
        $piece = $this->getPieceAt($from);
        if ($piece === null) {
            throw new Exception("Aucune pièce à cette position !");
        }
        if (!$piece->canMove($this, $to)) {
            throw new Exception("Mouvement invalide pour cette pièce !");
        }

        $this->removePieceAt($from);
        $this->placePiece($piece);
    }
    public function isPathClear(Position $from, Position $to): bool {
        $dfRow = $to->getRow() - $from->getRow();
        $dfCol = $to->getColumn() - $from->getColumn();

        $stepRow = ($dfRow === 0) ? 0 : $dfRow / abs($dfRow);
        $stepCol = ($dfCol === 0) ? 0 : $dfCol / abs($dfCol);

        $currRow = $from->getRow() + $stepRow;
        $currCol = $from->getColumn() + $stepCol;

        while ($currRow !== $to->getRow() || $currCol !== $to->getColumn()) {
            if ($this->hasPieceAt(new Position((int)$currRow, (int)$currCol))) {
                throw new NoPieceException();
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
        //fait par IA
        $out = "";
        for ($r = 0; $r <= 7; $r++) {
            $out .= $r . " | ";
            for ($c = 0; $c <= 7; $c++) {
                $p = $this->getPieceAt(new Position($r, $c));
                $out .= ($p ? $p->render() : ". ") . " ";
            }
            $out .= "\n";
        }
        $out .= "    0 1 2 3 4 5 6 7\n";
        return $out;
    }

}
$position=new Position(1,1);
$position2=new Position(3,1);

$piece= new King(PieceColor::WHITE,$position);

$board=new Board();
$board->placePiece($piece);

var_dump($board->getKingPosition(PieceColor::WHITE));

var_dump($board->render());

//$factory = new PieceFactory();
//$board = new Board();
//
//// On crée une pièce via la factory
//$whiteKing = $factory->create(PieceType::KING, PieceColor::WHITE, new Position(7, 4));
//$board->placePiece($whiteKing);
//
//// On crée une autre pièce
//$blackQueen = $factory->create(PieceType::QUEEN, PieceColor::BLACK, new Position(0, 3));
//$board->placePiece($blackQueen);
//
//echo $board->render();
