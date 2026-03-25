<?php

interface InterfaceBoard{
    public function placePiece(Piece $piece): void;
    public function getPieceAt(Position $position): ?Piece;
    public function hasPieceAt(Position $position): bool;
    public function removePieceAt(Position $position): void;
    public function movePiece(Position $from, Position $to): void;
    public function isPathClear(Position $from, Position $to): bool;
    public function getPieces(): array;
    public function getKingPosition(PieceColor $color): ?Position;
    public function render(): string;
}