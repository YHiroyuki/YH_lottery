<?php

class RoundRobinMethod
{
    private $elements = [];
    private $total = 0;

    public function __construct($elements)
    {
        $this->elements = $elements;
        $this->total = array_sum($this->elements);
    }

    public function choice() {
        $choiceWeight = rand(1, $this->total);

        $sumWeight = 0;
        foreach ($this->elements as $i => $weight) {
            $sumWeight += $weight;
            if ($choiceWeight <= $sumWeight) {
                return $i;
            }
        }

        return null;
    }
}
