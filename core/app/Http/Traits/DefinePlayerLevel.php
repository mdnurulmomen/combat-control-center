<?php

namespace App\Http\Traits;

trait DefinePlayerLevel 
{
	public function definePlayerLevel($currentXpPoint)
    {
        $x = 0;
        $m = 0;

        while ($m <= $currentXpPoint) {
            $x++;
            $m += $x * ($x + 1) * 25;
        }

        return $x;
    }
}