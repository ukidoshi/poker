<?php
// Код для тестовой задачи: игра "покер на костях".
// Сарыглар Начын

// Функция для генерации случайных костей
function rollDice(): int
{
    return mt_rand(1, 6);
}

// Функция для броска всех пяти костей
function rollAllDice(): array
{
    $dice = [];
    for ($i = 0; $i < 5; $i++) {
        $dice[] = rollDice();
    }
    return $dice;
}

// Функция для определения комбинации
function determineCombination($dice): string
{
    // Ассоц. массив с количеством каждого значения в 5 кубиках.
    $counts = array_count_values($dice);

//    var_dump($counts);

    // Покер
    if (in_array(5, $counts)) {
        return "Покер";
    }

    // Каре
    foreach ($counts as $value => $count) {
        if ($count == 4) {
            return "Каре";
        }
    }

    // Фул хаус
    $values = array_values($counts);
    if (in_array(3, $values) && in_array(2, $values)) {
        return "Фул хаус";
    }

    // Большой стрит
    sort($dice);
    if ($dice == [1, 2, 3, 4, 5] || $dice == [2, 3, 4, 5, 6]) {
        return "Большой стрит";
    }

    // Малый стрит
    $unique = array_unique($dice);
    sort($unique);
    if (count($unique) == 4 && (($unique[3] - $unique[0]) == 3)) {
        return "Малый стрит";
    }

    // Тройка
    foreach ($counts as $value => $count) {
        if ($count == 3) {
            return "Тройка";
        }
    }

    // Две пары
    $pairs = 0;
    foreach ($counts as $value => $count) {
        if ($count == 2) {
            $pairs++;
        }
    }
    if ($pairs == 2) {
        return "Две пары";
    }

    // Пара
    foreach ($counts as $value => $count) {
        if ($count == 2) {
            return "Пара";
        }
    }

    // Шанс
    return "Шанс";
}

// Бросаем кости и определяем комбинацию
$dice = rollAllDice();
//$combination = determineCombination([3,3,2,3,3]);
$combination = determineCombination($dice);

// Выводим результат
echo "Бросок: " . implode(", ", $dice) . "\n";
echo "Комбинация: " . $combination;
