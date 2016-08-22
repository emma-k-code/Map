<?php

require_once 'Map.php';

$row = 10;
$column = 10;
$m = 40;

$total = $row * $column;

$map = new Map;
$showMap = $map->createMap($row,$column,$m);

foreach ($showMap as $key=>$value) {
    echo $showMap[$key];

    if (($key % $row) == 0 && ($key != $total)) {
        echo 'N';
    }
}
