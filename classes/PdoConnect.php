<?php

class PdoConnect {
    private const HOST = 'localhost'; // Хост с БД
    private const DB = 'happynewyear'; // Название базы данных
    private const USER = 'root'; // Имя пользователя БД (как в phpmyAdmin)
    private const PASS = ''; // Пароль пользователя БД (как в phpmyAdmin)
    private const CHARSET = 'utf8'; // Кодировка базы данных

    protected static $_instance; // Свойство класса, в котором будем хранить обьект текущего класса

    protected $DSN; // Содержит параметры БД
    protected $OPD; // Свойство, в которое записываются параметры для PDO
    public $PDO; // Свойство класса с методом PDO

    private function __construct() // Конструктор, который вызывается при создании объекта класса
    {
        $this->DSN = "mysql:host=" . self::HOST . ";dbname=" . self::DB . ";charset=" . self::CHARSET;
        // Сообщаем, что мы подключаемся к БД

        $this->OPD = array( // Записываем в параметр с которыми формируем объект PDO
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Тип возвращения ошибок
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Режим выборки данных по умолчанию
            PDO::ATTR_EMULATE_PREPARES => false, // Омуляция подготовленых выражений
        );

        $this->PDO = new PDO($this->DSN, self::USER, self::PASS, $this->OPD);
    }

    public static function getInstance() { // К этому обьекту обращаемся, когда нужно получить обьект класса
        if (self::$_instance === null) // Проверяем, есть ли обьект класса в свойстве $_instance
            self::$_instance = new self;
/*
Если его нет, создаем обьект, записываем в свойство $_instance и в конце
возвращаем. Если есть, выше описаный код отработал ранее, мы имеем объект класса
в свойстве $_instance, просто возвращаем его.
*/

// spl_autoload_register — Регистрирует заданную функцию в качестве реализации метода __autoload()

        return self::$_instance;
    }

    public function __clone(){}
    public function __wakeup(){}
}


?>