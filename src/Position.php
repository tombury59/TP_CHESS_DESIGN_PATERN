<?php
namespace App;
use App\Position;
use App\Exception\InvalidBoardSizeException;


/**
 * Classe Position
 * 
 * Représente des coordonnées sur le plateau d'échecs (ligne, colonne).
 */
class Position
{
    private int $row;
    private int $column;

    /**
     * @param int $row Ligne de 0 à 7
     * @param int $column Colonne de 0 à 7
     * @throws InvalidBoardSizeException Si les coordonnées sont hors limites
     */
    public function __construct(int $row,int $column)
    {
        if ($row < 0 || $row > 7 || $column < 0 || $column > 7) {
            throw new InvalidBoardSizeException();
        }

        $this->row = $row;
        $this->column = $column;
    }

    /**
     * @return int
     */
    public function getRow(): int{
        return $this->row;
    }

    /**
     * @return int
     */
    public function getColumn(): int{
        return $this->column;
    }

    /**
     * Compare cette position avec une autre.
     *
     * @param Position $other
     * @return bool
     */
    public function equals(Position $other): bool{
        return $other->getColumn()===$this->getColumn() && $other->getRow()===$this->getRow();
    }

    /**
     * Convertit la position en une clé chaîne (format "colonne:ligne").
     *
     * @return string
     */
    public function toKey(): string {
        return "{$this->getColumn()}:{$this->getRow()}";
    }

    /**
     * Crée une position à partir d'une clé chaîne.
     *
     * @param string $key
     * @return Position
     */
    public static function fromKey(string $key): Position{
        $explode=explode(":",$key);

        return new Position((int)$explode[0],(int)$explode[1]);
    }
}
