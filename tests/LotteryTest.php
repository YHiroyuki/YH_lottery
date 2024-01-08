<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use App\Lottery\EqualityLottery;
use App\Lottery\WeightedLottery;

use Tests\Mocks\LotteryItem;


class LotteryTest extends TestCase
{
    protected function setUp() :void {
    }

    public function test_EqualityLottery()
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
        $lottery = EqualityLottery::init($elements);

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

    public function test_WeightedLottery()
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

    public function test_Mixed()
    {
        $sampleNum = 10000;

        $groupA = EqualityLottery::initWithWeight([
            new LotteryItem(11, 0),
            new LotteryItem(12, 0),
        ], 60);
        $groupB = EqualityLottery::initWithWeight([
            new LotteryItem(21, 0),
            new LotteryItem(22, 0),
            new LotteryItem(23, 0),
        ], 30);

        $lottery = WeightedLottery::init([
            new LotteryItem(30, 10),
            $groupA,
            $groupB
        ]);

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


    }
}
