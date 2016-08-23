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
    if (preg_match( '/^([0-8mN]+)$/', $map)) {
        $error .= '格式錯誤，M大小寫錯誤\n';
    } elseif (preg_match( '/^([0-8Mn]+)$/', $map)) {
        $error .= '格式錯誤，N大小寫錯誤\n';
    } elseif (preg_match( '/^([0-8mnMN]+)$/', $map)) {
        $error .= '格式錯誤，大小寫錯誤\n';
    } elseif (preg_match( '/^([0-8a-zA-Z]+)$/', $map)) {
        $error .= '格式錯誤，含有MN以外的英文字\n';
    } elseif (preg_match( '/^([0-9]+)$/', $map)) {
        $error .= '格式錯誤，輸入的字串僅有數字\n';
    } elseif (preg_match( '/^([0-9a-zA-Z]+)$/', $map)) {
        $error .= '格式錯誤，輸入的字串含有有數字9\n';
    } else {
        $error .= '格式錯誤，輸入的字串含有其他非格式內的字元\n';
    }
}

// 如果字串長度不符合
if ($length != $mapLength) {
    if ($length < $mapLength ) {
        $error .= '字串長度錯誤，輸入的字串長度為'. $length .'，少於'. $mapLength .'\n';
    }
    if ($length > $mapLength ) {
        $error .= '字串長度錯誤，輸入的字串長度為'. $length .'，大於'. $mapLength .'\n';
    }
}

$map = strtoupper($map);

// 檢查N的數量
$n = 0;
for ($i = 0; $i < $length; $i++) {
    if (substr($map, $i, 1) === 'N') {
        $n++;
    }
}

if ($n != $nCorrect) {
    if ($n < $nCorrect) {
        $error .= '斷行數量錯誤，輸入的斷行數為'. $n .'，少於' . $nCorrect . '\n';
    }
    if ($n > $nCorrect) {
        $error .= '斷行數量錯誤，輸入的斷行數為'. $n .'，大於' . $nCorrect . '\n';
    }
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
        $error .= '地雷數量錯誤，輸入的地雷數為'. $m .'，少於' . $mCorrect . '\n';
    }
    if ($m > $mCorrect) {
        $error .= '地雷數量錯誤，輸入的地雷數為'. $m .'，大於' . $mCorrect . '\n';
    }
}

$checkMap = explode('N', $map);

// 檢查每排的長度
foreach ($checkMap as $key=>$value) {
    if (strlen($value) != $row) {
        $errorRow .= ($key + 1) . ',';
    }
}

if (isset($errorRow)) {
    if ($errorRow < $row) {
        $errorRow = substr($errorRow, 0, (strlen($errorRow) - 1));
        $error .= '行的長度錯誤，第'. $errorRow .'行的長度不為' . $row . '。';
    }

}

// 檢查數字是否正確
foreach ($checkMap as $key=>$value) {
    for ($i = 0; $i < $row; $i++) {
        if (preg_match( '/^([0-9]+)$/', substr($value, $i, 1))) {
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
    $error .= '字串內的數字有誤';
    foreach ($errorM as $key=>$value) {
        $error .= '，第' . $key . '個數字為' . $value[0] . '，正確應為' . $value[1];
    }
}

// 如果上述檢查都通過
if (isset($error)) {
    echo '不符合，因為下列原因\n';
    echo $error;
} else {
    echo '符合';
}
