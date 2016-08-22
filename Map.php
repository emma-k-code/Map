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
                // 判斷是否為最右側
                if (($key % $row) != 0) {
                    // 右
                    if ($map[$key + 1] === 'M') {
                        $map[$key]++;
                    }
                    // 右下
                    if ($map[$key + ($row + 1)] === 'M') {
                        $map[$key]++;
                    }
                    // 右上
                    if ($map[$key - ($row + 1)] === 'M') {
                        $map[$key]++;
                    }
                }

                // 判斷是否為最左側
                if (($key % $row) != 1) {
                    // 左
                    if ($map[$key - 1] === 'M') {
                        $map[$key]++;
                    }
                    // 左下
                    if ($map[$key + ($row - 1)] === 'M') {
                        $map[$key]++;
                    }
                    // 左上
                    if ($map[$key - ($row - 1)] === 'M') {
                        $map[$key]++;
                    }
                }

                // 下
                if ($map[$key + $row] === 'M') {
                    $map[$key]++;
                }
                // 上
                if ($map[$key - $row] === 'M') {
                    $map[$key]++;
                }
            }
        }

        return $map;
    }

}