<?php

namespace App\Lottery;

use App\Lottery\Interface\WeightedInterface;

class EqualityLottery extends Base implements WeightedInterface
{
    private $elements = [];
    private $weight=0;

    public static function initWithWeight(array $elements, $weight)
    {
        $lottery = self::init($elements);
        $lottery->weight = $weight;
        return $lottery;
    }

    public static function init(array $elements)
    {
        $lottery = new self();
        $lottery->elements = $elements;

        return $lottery;
    }

    protected function choiceFunc()
    {
        $index = mt_rand(0, count($this->elements) - 1);
        return $this->elements[$index];
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
