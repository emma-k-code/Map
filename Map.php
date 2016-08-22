<?php

class Map
{
    public function createMap($row = 9, $column = 9, $m = 10)
    {
        $total = $row * $column;

        for ($i = 1; $i <= $total; $i++) {
            $map[$i] = 0 ;
        }

        $rand = array_rand($map, $m);

        foreach ($map as $key=>$value) {
            if (in_array($key, $rand)) {
                $map[$key] = 'M';
            }
        }

        foreach ($map as $key=>$value) {
            if ($value === 0) {
                if ($map[$key + 1] === 'M' && (($key % $row) != 0)) {
                    $map[$key]++;
                }
                if ($map[$key - 1] === 'M' && (($key % $row) != 1)) {
                    $map[$key]++;
                }
                if ($map[$key + $row] === 'M') {
                    $map[$key]++;
                }
                if ($map[$key - $row] === 'M') {
                    $map[$key]++;
                }
                if ($map[$key + $row -1] === 'M' && (($key % $row) != 1)) {
                    $map[$key]++;
                }
                if ($map[$key + $row +1] === 'M' && (($key % $row) != 0)) {
                    $map[$key]++;
                }
                if ($map[$key - $row -1] === 'M' && (($key % $row) != 1)) {
                    $map[$key]++;
                }
                if ($map[$key - $row +1] === 'M' && (($key % $row) != 0)) {
                    $map[$key]++;
                }
            }
        }

        return $map;
    }

}