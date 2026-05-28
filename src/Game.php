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


/**
 * Classe Game
 * 
 * Moteur principal du jeu d'échecs. Gère les tours de jeu, le plateau, 
 * les règles de déplacement de base (roque, échec, etc.).
 */
class Game{
    private Board $board;
    private PieceColor $currentPlayer;
    private PieceFactory $pieceFactory;

    public function __construct(){
        $this->board = new Board();
        $this->currentPlayer = PieceColor::WHITE;
        $this->pieceFactory = new PieceFactory();
    }
    /**
     * Initialise la partie en positionnant les pièces.
     */
    public function start(): void{
        $this->setupPieces();
    }

    /**
     * Retourne le plateau de jeu actuel.
     *
     * @return Board
     */
    public function getBoard(): Board{
        return $this->board;
    }
    /**
     * Retourne la couleur du joueur dont c'est le tour.
     *
     * @return PieceColor
     */
    public function getCurrentPlayer(): PieceColor{
        return $this->currentPlayer;
    }

    /**
     * Exécute un mouvement sur l'échiquier.
     * Vérifie la validité du mouvement (tour, possibilité, roque, échec).
     *
     * @param Move $move
     * @throws NoPieceException
     * @throws WrongTurnException
     * @throws InvalidMoveException
     */
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
        if ($piece->getType() === PieceType::KING
            && abs($move->getTo()->getColumn() - $move->getFrom()->getColumn()) === 2) {

            $row = $move->getFrom()->getRow();

            // petit roque
            if ($move->getTo()->getColumn() === 6) {

                $rookFrom = new Position($row, 7);
                $rookTo   = new Position($row, 5);

            }
            // grand roque
            else {

                $rookFrom = new Position($row, 0);
                $rookTo   = new Position($row, 3);
            }

            $rook = $this->board->getPieceAt($rookFrom);

            if ($rook === null || $rook->getType() !== PieceType::ROOK || $rook->hasMoved()) {
                throw new InvalidMoveException("Roque impossible : tour invalide.");
            }

            $kingPathClear = $this->board->isPathClear(
                $move->getFrom(),
                new Position($row, $move->getTo()->getColumn())
            );

            if (!$kingPathClear) {
                throw new InvalidMoveException("Le roque est impossible : le chemin du roi n'est pas libre.");
            }

            $this->board->movePiece($rookFrom, $rookTo);
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
    /**
     * Vérifie si le roi de la couleur donnée est en échec.
     *
     * @param PieceColor $color
     * @return bool
     */
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
    /**
     * Place les pièces en position initiale sur le plateau.
     */
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
    /**
     * Alterne le tour du joueur courant.
     */
    private function switchPlayer(): void{
        $this->currentPlayer = $this->currentPlayer->opposite();    
    }
}