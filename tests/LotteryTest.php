<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use App\Lottery\WeightedLottery;

use Tests\Mocks\LotteryItem;


class LotteryTest extends TestCase
{
    protected function setUp() :void {
    }

    public function test_WeightLottery()
    {
        $sampleNum = 10000;

        // テストデータ
        $weights = [10, 30, 60];
        $elements = [];
        $indexs = [];
        foreach ($weights as $idx => $weight) {
            $indexs[] = $idx;
            $elements[] = new LotteryItem($idx, $weight);
        }

        // テスト対象のモデル生成
        $lottery = WeightedLottery::init($elements);

        // サンプリング
        $result = [];
        $actualIndexs = [];
        for ($i=0; $i < $sampleNum; $i++) {
            /** @var LotteryItem $choiceElement */
            $choiceElement = $lottery->choice();
            $key = (string) $choiceElement;
            if (!isset($result[$key])) {
                $result[$key] = 0;
            }
            $result[$key]++;
            $actualIndexs[$choiceElement->getId()] = true;
        }

        // 結果
        foreach ($result as $key => $count) {
            printf("%s: %f\n", $key, $count / $sampleNum * 100);
        }
        ksort($actualIndexs);

        $this->assertEquals([0, 1, 2], array_keys($actualIndexs));
    }
}
