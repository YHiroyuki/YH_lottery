<?php

namespace App\Lottery;

use App\Lottery\Interface\WeightedInterface;


class WeightedLottery extends Base
{
    private $elements = [];
    private $averageWeight = 0;
    private $weights = [];
    private $aliases = [];

    public static function init(array $elements)
    {
        $lottery = new self();
        $lottery->elements = $elements;
        /** @var WeightedInterface $element */
        foreach ($elements as $element) {
            $lottery->weights[] = $element->getWeight();
        }
        $totalWeight = array_sum($lottery->weights);
        $count = count($elements);
        $lottery->averageWeight = $totalWeight / $count;

        $shorts = [];
        $learges = [];
        foreach ($lottery->weights as $i => $weight) {
            if ($weight < $lottery->averageWeight) {
                $shorts[] = $i;
            } else {
                $learges[] = $i;
            }
        }

        while (!empty($shorts) && !empty($learges)) {
            $shortIndex = array_pop($shorts);
            $leargeIndex = end($learges);
            $lottery->aliases[$shortIndex] = $leargeIndex;
            $lottery->weights[$leargeIndex] = $lottery->weights[$leargeIndex] - ($lottery->averageWeight - $lottery->weights[$shortIndex]);
            if ($lottery->weights[$leargeIndex] <= $lottery->averageWeight) {
                $shorts[] = $leargeIndex;
                array_pop($learges);
            }
        }

        return $lottery;
    }

    protected function choiceFunc()
    {
        $index = mt_rand(0, count($this->elements) - 1);
        $threshold = mt_rand() / mt_getrandmax() * $this->averageWeight;
        if ($this->weights[$index] <= $threshold) {
            $index = $this->aliases[$index];
        }

        return $this->elements[$index];
    }
}
