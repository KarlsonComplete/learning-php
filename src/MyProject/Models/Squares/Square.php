<?php

namespace MyProject\Models\Squares;

use MyProject\CalculateSquaresInterface\CalculateSquareInterface;

class Square implements CalculateSquareInterface
{
    private $x;

    public function __construct(float $x)
    {
        $this->x = $x;
    }

    public function calculateSquare(): float
    {
        return $this->x ** 2;
    }
}