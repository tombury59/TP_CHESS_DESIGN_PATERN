<?php

require_once __DIR__ . '/Board.php';
require_once __DIR__ . '/Move.php';
require_once __DIR__ . '/Piece/Piece.php';
require_once __DIR__ . '/Piece/Pawn.php';
require_once __DIR__ . '/Piece/Rook.php';
require_once __DIR__ . '/Piece/Knight.php';
require_once __DIR__ . '/Piece/Bishop.php';
require_once __DIR__ . '/Piece/Queen.php';
require_once __DIR__ . '/Piece/King.php';
require_once __DIR__ . '/Factory/PieceFactory.php';
require_once __DIR__ . '/Enum/PieceColor.php';
require_once __DIR__ . '/Enum/PieceType.php';
require_once __DIR__ . '/Exception/ChessException.php';
require_once __DIR__ . '/Exception/NoPieceException.php';
require_once __DIR__ . '/Exception/WrongTurnException.php';
require_once __DIR__ . '/Exception/InvalidMoveException.php';


class Game{
    private Board $board;
    private PieceColor $currentPlayer;
    private PieceFactory $pieceFactory;

    public function __construct(){
        $this->board = new Board();
        $this->currentPlayer = PieceColor::WHITE;
        $this->pieceFactory = new PieceFactory();
    }
    public function start(): void{
        $this->setupPieces();
    }
    public function getBoard(): Board{
        return $this->board;
    }
    public function getCurrentPlayer(): PieceColor{
        return $this->currentPlayer;
    }
    public function play(Move $move): void{
        $piece = $this->board->getPieceAt($move->getFrom());
        if ($piece === null) {
            throw new NoPieceException();
        }
        if ($piece->getColor() !== $this->currentPlayer) {
            throw new WrongTurnException();
        }
        if (!$piece->canMove($this->board,$move->getTo() )) {
            throw new InvalidMoveException();
        }
        $this->board->movePiece($move->getFrom(), $move->getTo());
        $piece->setPosition($move->getTo());

        $capturedPiece = $this->board->getPieceAt($move->getTo());
        
        if ($this->isCheck($this->currentPlayer)) {
                // cancel move
                $this->board->movePiece($move->getTo(), $move->getFrom());
                $piece->setPosition($move->getFrom());

                if ($capturedPiece !== null) {
                    $this->board->placePiece($capturedPiece);
                }

                throw new InvalidMoveException("Coup illégal : Votre roi est en échec !");
            }
        $this->switchPlayer();
    }
    public function isCheck(PieceColor $color): bool {
        $kingPosition = $this->board->getKingPosition($color);
        if ($kingPosition === null) return false;

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getColor() !== $color) {
                try {
                    if ($piece->canMove($this->board, $kingPosition)) {
                        return true;
                    }
                } catch (ChessException $e) {
                    continue; 
                }
            }
        }
        return false;
    }
    private function setupPieces(): void{
        $pieces = [
            PieceType::ROOK,
            PieceType::KNIGHT,
            PieceType::BISHOP,
            PieceType::QUEEN, 
            PieceType::KING, 
            PieceType::BISHOP, 
            PieceType::KNIGHT, 
            PieceType::ROOK
        ];

        foreach ($pieces as $index => $type) {
            $this->board->placePiece($this->pieceFactory->create($type, PieceColor::WHITE, new Position(7, $index)));
            $this->board->placePiece($this->pieceFactory->create(PieceType::PAWN, PieceColor::WHITE, new Position(6, $index)));

            $this->board->placePiece($this->pieceFactory->create($type, PieceColor::BLACK, new Position(0, $index)));
            $this->board->placePiece($this->pieceFactory->create(PieceType::PAWN, PieceColor::BLACK, new Position(1, $index)));
        }

    }
    private function switchPlayer(): void{
        $this->currentPlayer = $this->currentPlayer->opposite();    
    }
}

// $game = new Game();

// $game->start();

// echo $game->getBoard()->render();

// var_dump($game->getCurrentPlayer());
// var_dump($game->getBoard()->getPieces());
// $game->play(new Move(new Position(6,4), new Position(4,4)));
// echo $game->getBoard()->render();
// var_dump($game->getCurrentPlayer());

// echo "check ? " . ($game->isCheck($game->getCurrentPlayer()) ? "true" : "false") . "\n";