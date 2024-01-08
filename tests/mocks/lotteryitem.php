<?php

namespace Tests\Mocks;

use App\Lottery\Interface\WeightedInterface;



class LotteryItem implements WeightedInterface
{
    private $id;
    private $weight;

    public function __construct($id, $weight)
    {
        $this->id = $id;
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function __toString()
    {
        return sprintf("ID: %d (%d)", $this->id, $this->weight);
    }
}
