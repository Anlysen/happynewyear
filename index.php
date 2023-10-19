<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});
// В качестве оргументов функции, мы записываем анонимную функцию с одним оргументом

// Функция - которая вернет количество секунд с сегоднешнего дня
// до следующего повторения переданной даты

function secondToDate($month, $day) {
    
    $currentDate = date('Y.m.d.H.i.s', time()); // Текущая дата
    $currentDateArray = explode('.', $currentDate);

// explode — Разбивает строку с помощью разделителя

if ($currentDateArray[1] > $month || ($currentDateArray[1] == $month && $currentDateArray > $day)) {
        $year = $currentDateArray[0] + 1;
} elseif ($currentDateArray[1] == $month && $currentDateArray[2] == $day) {
    return 0;
} else {
    $year = $currentDateArray[0];
}
$dateFrom = date_create($currentDateArray[0] . "-" . $currentDateArray[1] . "-" .
$currentDateArray[2] . " " . $currentDateArray[3] . ":" . $currentDateArray[4] . ":" . $currentDateArray[5]);
$dateTo = date_create($year . "-" . $month . "-" . $day);

$diff = date_diff($dateTo, $dateFrom);

return ($diff->y * 365 * 24 * 60 * 60) +
       ($diff->m * 30 * 24 * 60 * 60) +
       ($diff->d * 24 * 60 * 60) +
       ($diff->h * 24 * 60 * 60) +
       ($diff->i * 60) +
        $diff->s;
}

$secondTo = secondToDate(12, 24);

// Подключаем таймер активации акции

$currentDate = date('m.y', time()); // Текущий день
$currentDateArray = explode('.', $currentDate); // explode — Разбивает строку с помощью разделителя

$currentMonth = $currentDateArray[0];
$currentDay = $currentDateArray[1];

$currentMonth = 12;
$currentDay = 24;


// Добавляем товар в БД
// $sql = "
//     INSERT INTO goods (name, price, image) VALUES 
//     ('Шоколадный дед мороз', '100 руб.', 'static/img/product-2.png'),
//     ('Новогодняя Ёлка', '9900 руб.', 'static/img/product-3.jpg'),
//     ('Сладкая коробка', '600 руб.', 'static/img/product-4.jpg'),
//     ('Фигурка деда мороза', '2000 руб.', 'static/img/product-5.jpg'),
//     ('Новогодний шар', '3000 руб.', 'static/img/product-6.jpg'),
//     ('Шар на елку', '300 руб.', 'static/img/product-7.jpg'),
//     ('Мишура', '120 руб.', 'static/img/product-8.jpg'),
//     ('Гирлянда \"Лампочки\"', '1200 руб.', 'static/img/product-9.jpg'),
//     ('Новогоднее шампанское', '240 руб.', 'static/img/product-10.jpg'),
//     ('Коробка конфет', '250 руб.', 'static/img/product-11.jpg'),
//     ('Подарок \"Сюрприз\"', '900 руб.', 'static/img/product-12.jpg'),
//     ('Звезда на Елку', '400 руб.', 'static/img/product-13.jpg'),
//     ('Шапка новогодняя', '600 руб.', 'static/img/product-14.jpg'),
//     ('Бенгальские огни', '100 руб.', 'static/img/product-15.jpg'),
//     ('Хлопушка', '80 руб.', 'static/img/product-16.png')
// "; // Тут в начале данных name, price, image, не ставим кавычки

// Создаем таблицу БД
// $sql = "
//     CREATE TABLE IF NOT EXISTS goods
//     (
//         id int NOT NULL AUTO_INCREMENT,
//         name varchar(255) NOT NULL,
//         price varchar(255) NOT NULL,
//         image varchar(255) NOT NULL,
//         PRIMARY KEY(id)
//     ) CHARSET=utf8
// ";
// var_dump($res);
// die();

if ($currentMonth == 12 && $currentDay >= 24) {
    $PDO = PdoConnect::getInstans();

// $sql = "
//     CREATE TABLE IF NOT EXISTS orders
//     (
//         id int NOT NULL AUTO_INCREMENT,
//         fio varchar(255) NOT NULL,
//         phone varchar(255) NOT NULL,
//         email varchar(255) NOT NULL,
//         comment text NOT NULL,
//         product_id int NOT NULL,
//         PRIMARY KEY (id)
//     ) CHARSET=utf8
// ";

// $result = $PDO->PDO->query($sql);
// var_dump($result);

// Извлекаем все данные из таблицы
    $result = $PDO->PDO->query("
         SELECT * FROM `goods`
    ");

$products = array(); // Массив для товаров

    while ($productInfo = $result->fetch()) { // Для получения строк из результирующего набора
        $products[] = $productInfo;
    }


    include 'online_store.php';
} else {
    include 'time.php';
}
// Выражение include включает и выполняет указанный файл


?>