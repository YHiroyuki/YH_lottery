<?php

class WalkersAliasMethod
{
    private $elements = [];
    private $aliases = [];
    private $ave = 0;

    public function __construct($elements)
    {
        $this->elements = $elements;
        $total = array_sum($this->elements);
        $count = count($elements);
        $ave = $total / $count;
        $this->ave = $ave;

        $shorts = [];
        $learges = [];
        foreach ($elements as $i => $weight) {
            if ($weight < $ave) {
                $shorts[] = $i;
            } else {
                $learges[] = $i;
            }
        }
        while (!empty($shorts) && !empty($learges)) {
            $s_i = array_pop($shorts);
            $l_i = end($learges);
            $this->aliases[$s_i] = $l_i;
            // $this->thresholds[$s_i] = $elements[$s_i];
            $this->elements[$l_i] = $this->elements[$l_i] - ($ave - $this->elements[$s_i]);
            if ($this->elements[$l_i] <= $ave) {
                $shorts[] = $l_i;
                array_pop($learges);
            }
        }
    }

    public function choice()
    {
        $threshold = mt_rand() / mt_getrandmax() * $this->ave;
        $index = mt_rand(0, count($this->elements) - 1);
        if ($threshold >= $this->elements[$index]) {
            return $this->aliases[$index];
        }
        return $index;
    }
}
