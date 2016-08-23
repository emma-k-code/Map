<?php

header("content-type: text/html; charset=utf-8");

$row = 10;
$column = 10;
$mCorrect = 40; // M的正確數量
$nCorrect = ($row - 1); // N的正確數量
$mapLength = $row * $column + $nCorrect; // 字串的正確長度

$map = $_GET['map'];
$length = strlen($map);

// 檢查大小寫與其他英文字
if (!preg_match( '/^([0-8MN]+)$/', $map)) {
    if (preg_match( '/^([0-8mnMN]+)$/', $map)) {
        echo  '不符合，因為輸入的字串大小寫錯誤。';
    } elseif (preg_match( '/^([0-8a-zA-Z]+)$/', $map)) {
        echo  '不符合，因為輸入的字串含有MN以外的英文字。';
    } elseif (preg_match( '/^([0-9]+)$/', $map)) {
        echo  '不符合，因為輸入的字串僅有數字。';
    } elseif (preg_match( '/^([0-9a-zA-Z]+)$/', $map)) {
        echo  '不符合，因為輸入的字串有大於8的數字。';
    } else {
        echo  '不符合，因為輸入的字串含有其他非格式內的字元。';
    }
    return;
}

// 如果字串長度不符合
if ($length != $mapLength) {
    if ($length < $mapLength ) {
        echo '不符合，因為輸入的字串長度為'. $length .'，少於'. $mapLength .'。';
    }
    if ($length > $mapLength ) {
        echo '不符合，因為輸入的字串長度為'. $length .'，大於'. $mapLength .'。';
    }
    return;
}

// 檢查N的數量
$n = 0;
for ($i = 0; $i < $length; $i++) {
    if (substr($map, $i, 1) === 'N') {
        $n++;
    }
}

if ($n != $nCorrect) {
    if ($n < $nCorrect) {
        echo '不符合，因為N的數量為'. $n .'，少於' . $nCorrect . '。';
    }
    if ($n > $nCorrect) {
        echo '不符合，因為N的數量為'. $n .'，大於' . $nCorrect . '。';
    }
    return;
}

// 檢查M的數量
$m = 0;
for ($i = 0; $i < $length; $i++) {
    if (substr($map, $i, 1) === 'M') {
        $m++;
    }
}

if ($m != $mCorrect) {
    if ($m < $mCorrect) {
        echo '不符合，因為M的數量為'. $m .'，少於' . $mCorrect . '。';
    }
    if ($m > $mCorrect) {
        echo '不符合，因為M的數量為'. $m .'，大於' . $mCorrect . '。';
    }
    return;
}

$checkMap = explode('N', $map);

// 檢查每排的長度
foreach ($checkMap as $key=>$value) {
    if (strlen($value) != $row) {
        $errorRow .= ($key + 1) . ',';
    }
}

if (isset($errorRow)) {
    $errorRow = substr($errorRow, 0, (strlen($errorRow) - 1));
    echo '不符合，因為第'. $errorRow .'排的長度不為' . $row . '。';

    return;
}

// 檢查數字是否正確
foreach ($checkMap as $key=>$value) {
    for ($i = 0; $i < $row; $i++) {
        if (substr($value, $i, 1) !== 'M') {
            $checkAround = 0;
            // 判斷是否為最右側
            if ($i != 9) {
                // 右
                if (substr($value, ($i + 1), 1) === 'M') {
                    $checkAround++;
                }
                // 右下
                if (substr($checkMap[$key + 1], ($i + 1), 1) === 'M') {
                    $checkAround++;
                }
                // 右上
                if (substr($checkMap[$key - 1], ($i + 1), 1) === 'M') {
                    $checkAround++;
                }
            }

            // 判斷是否為最左側
            if ($i != 0) {
                // 左
                if (substr($value, ($i - 1), 1) === 'M') {
                    $checkAround++;
                }
                // 左下
                if (substr($checkMap[$key + 1], ($i - 1), 1) === 'M') {
                    $checkAround++;
                }
                // 左上
                if (substr($checkMap[$key - 1], ($i - 1), 1) === 'M') {
                    $checkAround++;
                }
            }

            // 下
            if (substr($checkMap[$key + 1], $i, 1) === 'M') {
                $checkAround++;
            }
            // 上
            if (substr($checkMap[$key - 1], $i, 1) === 'M') {
                $checkAround++;
            }

            if (substr($value, $i, 1) != $checkAround) {
                $coordinate = $key * $row + ($i + 1) + $key;
                $errorM[$coordinate][] = substr($value, $i, 1);
                $errorM[$coordinate][] = $checkAround;
            }
        }
    }

}

if (isset($errorM)) {
    echo '不符合，因為字串內的數字有誤';
    foreach ($errorM as $key=>$value) {
        echo '，第' . $key . '個數字為' . $value[0] . '，正確應為' . $value[1];
    }
    echo '。';
    return;
}

// 如果上述檢查都通過
echo '符合';
