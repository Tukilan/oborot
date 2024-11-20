<?php
require_once(__DIR__ ."/../vendor/autoload.php");
require_once(__DIR__ ."/../garden.php");

use PHPUnit\Framework\TestCase;
class GardenTest extends TestCase
{
    public function testFillGarden()
    {
        $garden = new Garden();

        // Проверяем общее количество объектов в саду
        $this->assertCount(25, $garden->objects, 'Объектов в саду должно быть 25');

        // Проверяем распределение по типам
        $appleTrees = array_filter($garden->objects, function ($o) {
            return $o->entity->type === 'apple';
        });

        $pearTrees = array_filter($garden->objects, function ($o) {
            return $o->entity->type === 'pear';
        });

        $this->assertCount(15, $appleTrees, 'Должно быть 15 яблонь');
        $this->assertCount(10, $pearTrees, 'Должно быть 10 груш');
    }

    public function testCollect()
    {
        $garden = new Garden();
        $collected = $garden->collect();

        // Проверяем, что собранные данные не пусты
        $this->assertNotEmpty($collected, 'Собранные данные не должны быть пустыми');
        $this->assertArrayHasKey('tree', $collected, 'Собранные данные должны содержать ключ "tree"');

        // Проверяем, что в собранных данных есть яблоки и груши
        $this->assertArrayHasKey('apple', $collected['tree'], 'Должны быть собраны яблоки');
        $this->assertArrayHasKey('pear', $collected['tree'], 'Должны быть собраны груши');
    }

    public function testGetWeight()
    {
        $garden = new Garden();
        $garden->collect();
        $weights = $garden->getWeight();

        // Проверяем, что вес посчитан для каждого типа
        $this->assertArrayHasKey('apple', $weights, 'Должен быть подсчитан вес яблок');
        $this->assertArrayHasKey('pear', $weights, 'Должен быть подсчитан вес груш');

        // Проверяем, что вес положительный
        $this->assertGreaterThan(0, $weights['apple'], 'Вес яблок должен быть больше 0');
        $this->assertGreaterThan(0, $weights['pear'], 'Вес груш должен быть больше 0');
    }

    public function testGetMaxWeight()
    {
        $garden = new Garden();
        $garden->collect();

        $maxApple = $garden->getMaxWeight('tree', 'apple');
        $maxPear = $garden->getMaxWeight('tree', 'pear');

        // Проверяем, что объект с максимальным весом найден
        $this->assertNotEmpty($maxApple['id'], 'Должен быть найден объект с максимальным весом для яблок');
        $this->assertNotEmpty($maxPear['id'], 'Должен быть найден объект с максимальным весом для груш');

        // Проверяем, что вес больше 0
        $this->assertGreaterThan(0, $maxApple['max'], 'Максимальный вес яблока должен быть больше 0');
        $this->assertGreaterThan(0, $maxPear['max'], 'Максимальный вес груши должен быть больше 0');
    }

    public function testCountCollectedObjects()
    {
        $garden = new Garden();
        $garden->collect();

        // Перехватываем вывод метода
        ob_start();
        $garden->countCollectedObjects();
        $output = ob_get_clean();

        // Проверяем наличие информации о яблоках и грушах в выводе
        $this->assertStringContainsString('apple', $output, 'Должна быть информация о собранных яблоках');
        $this->assertStringContainsString('pear', $output, 'Должна быть информация о собранных грушах');
    }
}