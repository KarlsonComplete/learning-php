<?php

namespace MyProject\Models\Circles;

use MyProject\CalculateSquaresInterface\CalculateSquareInterface;

class Circle implements CalculateSquareInterface
{
    const PI = 3.1416;

    private $r;

    public function __construct(float $r)
    {
        $this->r = $r;
    }

    public function calculateSquare(): float
    {
        return self::PI * ($this->r ** 2);
    }
}