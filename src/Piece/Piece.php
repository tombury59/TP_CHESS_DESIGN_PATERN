<?php

abstract class Piece
{
    protected PieceColor $color;
    protected Position $position;
    protected PieceType $type;

    public function __construct(PieceColor $color, Position $position){
        $this->color=$color;
        $this->position=$position;
    }
    public function getColor(): PieceColor{
        return $this->color;
    }
    public function getPosition(): Position{
        return $this->position;
    }
    public function setPosition(Position $position): void{
        $this->position=$position;
    }
    public function getType(): PieceType{
        return $this->type;
    }
    public function render(): string {
        $isWhite = $this->color === PieceColor::WHITE;

        return match($this->type) {
            PieceType::KING   => $isWhite ? 'K' : 'k',
            PieceType::QUEEN  => $isWhite ? 'Q' : 'q',
            PieceType::ROOK   => $isWhite ? 'R' : 'r',
            PieceType::BISHOP => $isWhite ? 'B' : 'b',
            PieceType::KNIGHT => $isWhite ? 'N' : 'n',
            PieceType::PAWN   => $isWhite ? 'P' : 'p',
        };
    }

    public function canMove(Board $board, Position $target): bool
    {
        // 1.la pièce ne reste pas sur place
        if ($this->position->equals($target)) {
            throw new SameTileException();
        }

        // 2.la forme du déplacement est valide
        if (!$this->isValidMovementShape($target)) {
            throw new InvalidMoveException();
        }

        // 3.la case cible n'est pas occupée par un allié
        $targetPiece = $board->getPieceAt($target);
        if ($targetPiece !== null && $targetPiece->getColor() === $this->color) {
            throw new OccupiedByAllyException();
        }

        // 4.si la pièce n'est pas un cavalier, le chemin est libre
        if ($this->type !== PieceType::KNIGHT) {
            if (!$board->isPathClear($this->position, $target)) {
                throw new InvalidMoveException();
            }
        }

        return true;
    }

    abstract protected function isValidMovementShape(Position $target): bool;
    protected function canCapture(Board $board, Position $target): bool{

        //return $board->hasPieceAt($target) && $this->canMove($board,$target);
        return $board->hasPieceAt($target);
    }
}
