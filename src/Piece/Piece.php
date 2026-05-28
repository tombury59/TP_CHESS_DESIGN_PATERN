<?php

/**
 * Classe abstraite Piece
 * 
 * Représente une pièce générique du jeu d'échecs.
 * Définit le comportement commun à toutes les pièces.
 */
abstract class Piece
{
    protected PieceColor $color;
    protected Position $position;
    protected PieceType $type;

    /**
     * @param PieceColor $color Couleur de la pièce
     * @param Position $position Position initiale
     */
    public function __construct(PieceColor $color, Position $position){
        $this->color=$color;
        $this->position=$position;
        $this->hasMoved=false;
    }
    /**
     * @return PieceColor
     */
    public function getColor(): PieceColor{
        return $this->color;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position{
        return $this->position;
    }

    /**
     * Met à jour la position de la pièce.
     *
     * @param Position $position
     */
    public function setPosition(Position $position): void{
        $this->position=$position;
        $this->hasMoved = true;
    }

    /**
     * @return PieceType
     */
    public function getType(): PieceType{
        return $this->type;
    }
    /**
     * @return string Représentation ASCII de la pièce
     */
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

    /**
     * Vérifie si la pièce peut se déplacer vers la case cible.
     * Applique les règles génériques (pas sur place, chemin libre, pas sur allié).
     *
     * @param Board $board
     * @param Position $target
     * @return bool
     * @throws SameTileException
     * @throws InvalidMoveException
     * @throws OccupiedByAllyException
     */
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

    /**
     * Vérifie la validité du motif de déplacement spécifique à la pièce.
     *
     * @param Position $target
     * @return bool
     */
    abstract protected function isValidMovementShape(Position $target): bool;

    /**
     * Vérifie si la pièce peut capturer la cible.
     *
     * @param Board $board
     * @param Position $target
     * @return bool
     */
    protected function canCapture(Board $board, Position $target): bool{

        //return $board->hasPieceAt($target) && $this->canMove($board,$target);
        return $board->hasPieceAt($target);
    }

    /**
     * @return bool Vrai si la pièce a déjà bougé
     */
    public function hasMoved(){
        return $this->hasMoved;
    }
}
