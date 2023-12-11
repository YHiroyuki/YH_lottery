<?php

use PHPUnit\Framework\TestCase;
use App\Lottery\WalkersAliasMethod;


class LotteryTest extends TestCase
{
    protected function setUp() :void {
    }

    public function test_WalkersAliasMethod()
    {
        $elements = [10, 30, 60];
        $result = [0, 0 ,0];
        $method = new WalkersAliasMethod($elements);
        for ($i=0; $i<10000000; $i++) {
            $index = $method->choice();
            $result[$index] += 1;
        }

        $total = array_sum($result);

        foreach ($elements as $index => $lottery) {
            $actual = $result[$index] / $total * 100;
            $this->assertGreaterThanOrEqual($lottery - 0.1, $actual);
            $this->assertLessThanOrEqual($lottery + 0.1, $actual);
        }
    }
}
