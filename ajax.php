<?php

// Автоподключение классов
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

// Проверка на то, что идет ajax запрос
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) // Проверка на существования переменной
&& !empty($_SERVER['HTTP_X_REQUESTED_WITH']) // Проверка на то, что переменная не пуста
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// Пулучаем данные отправленные ajax-запросом
    $requestData = $_POST;

$errors = array();

if (!$requestData['id'])
    $errors[] = 'Не получен ID товара';

if (!$requestData['fio'])
    $errors[] = 'Поле "Ваше имя" обязательно для заполнения';

if (!$requestData['phone'] && !$requestData['email'])
    $errors[] = 'Вы должны заполнить как минимум одно поле "Телефон" или "Email"';

$response = array();

if ($errors) {
    $response['errors'] = $errors;
} else {
    $PDO = PdoConnect::getInstans();

    $sql = "
        INSERT INTO orders
        SET fio = :fio, phone = :phone, email = :email, comment = :comment, product_id = :id";

    $set = $PDO->PDO->prepare($sql);
    $response['res'] = $set->execute($requestData);

    if ($response['res']) {
        $message = "
        Оформлен новый заказ.
        Заказан товар с ID:" . $requestData['id'] . ", заказчик " . $requestData['fio'];

        mail('rostangeles1993@gmail.com', 'Оформлен новый заказ', $message, 'FROM: allochka.vardanyan.1997@mail.ru');
    }
}

    echo json_encode($response);
}


?>