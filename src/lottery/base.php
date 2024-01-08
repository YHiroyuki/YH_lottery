<?php

namespace App\Lottery;


abstract class Base
{
    abstract public static function init(array $elements);

    abstract protected function choiceFunc();

    public function choice()
    {
        $choiceContent = $this->choiceFunc();

        if ($choiceContent instanceof Base) {
            return $choiceContent->choice();

        }

        return $choiceContent;
    }
}
