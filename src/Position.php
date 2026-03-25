<?php

class Position
{
    private int $row;
    private int $column;

    public function __construct(int $row,int $column)
    {
        if ($row < 0 || $row > 7 || $column < 0 || $column > 7) {
            throw new InvalidBoardSizeException();
        }

        $this->row = $row;
        $this->column = $column;
    }

    public function getRow(): int{
        return $this->row;
    }

    public function getColumn(): int{
        return $this->column;
    }

    public function equals(Position $other): bool{
        return $other->getColumn()===$this->getColumn() && $other->getRow()===$this->getRow();
    }

    public function toKey(): string {
        return "{$this->getColumn()}:{$this->getRow()}";
    }

    public static function fromKey(string $key): Position{
        $explode=explode(":",$key);

        return new Position($explode[0],$explode[1]);
        // var_dump($result->toKey());
    }
}

//$pos1= new Position(1,1);

//$pos2= new Position(1,1);
//var_dump($pos1->equals($pos2));
