<?php

require_once('./walkersaliasmethod.php');
require_once('./roundrobinmethod.php');

function sample($className)
{
    print($className . "\n");
    $box = [1, 2, 3];
    $result = [0, 0, 0];

    $method = new $className($box);
    for ($i=0; $i<10000000; $i++) {
        $index = $method->choice();
        $result[$index] += 1;
    }

    $expectedTotal = array_sum($box);
    $total = array_sum($result);
    for ($i=0; $i<count($box); $i++) {
        print($i . ": ". ($box[$i] / $expectedTotal * 100) . "%\n");
        print($i . ": ". ($result[$i] / $total * 100) . "%\n");
    }
}


sample("WalkersAliasMethod");
sample("RoundRobinMethod");
