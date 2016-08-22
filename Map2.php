<?php

require_once 'Map.php';

$row = 60;
$column = 50;
$m = 1200;

$total = $row * $column;

$map = new Map;
$showMap = $map->createMap($row,$column,$m);

foreach ($showMap as $key=>$value) {
    echo $showMap[$key];

    if (($key % $row) == 0 && ($key != $total)) {
        echo 'N';
    }
}
