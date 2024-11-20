<?php
require_once(__DIR__.'/garden.php');
$sapi = php_sapi_name();
if ($sapi != "cli") {
    exit();
}

$garden = new Garden();
echo 'Инициализация сада и деревьев.'.PHP_EOL;
$garden->collect();
echo 'Плоды собраны'.PHP_EOL;
$garden->countCollectedObjects();

$weigthAll = $garden->getWeight();
foreach ($weigthAll as $key => $value) {
    echo 'Вес всех '.$key.' - '.$value.' гр'.PHP_EOL;
}
$maxAppleWeight = $garden->getMaxWeight('tree','apple');
echo 'Самое тяжелое яблоко - '.$maxAppleWeight['max'].' гр с дерева '.$maxAppleWeight['id'].PHP_EOL;
