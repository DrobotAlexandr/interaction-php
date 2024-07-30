<?php

namespace Interaction\Database;

use BasePhp\Config\Config;
use PDO;
use PDOStatement;
use PDOException;

/**
 * Класс Database
 *
 * Этот класс предоставляет абстракцию базы данных для подключения и взаимодействия с базой данных MySQL с использованием PDO.
 *
 * @package Prologue\Framework\Database
 */
class Database
{
    /**
     * @var Database Синглтон-экземпляр класса Database.
     */
    private static Database $instance;

    /**
     * @var string Название базы данных по умолчанию.
     */
    private static string $dbName = 'main';

    /**
     * @var array Массив соединений с базой данных.
     */
    private array $connections = [];

    /**
     * @var array Массив полей, используемых для выборки.
     */
    private static array $fl = [];

    /**
     * Получить экземпляр класса Database (Singleton).
     *
     * @return Database Экземпляр класса Database.
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Установить имя базы данных.
     *
     * @param string $dbname Имя базы данных.
     */
    public static function setDatabase(string $dbname): void
    {
        self::$dbName = $dbname;
    }

    /**
     * Сбросить настройки базы данных.
     */
    public static function refresh(): void
    {
        self::$dbName = 'main';
        self::$fl = [];
    }

    /**
     * Инициализация подключения к базе данных.
     *
     * @param array $params Параметры соединения.
     * @return PDO Объект PDO для подключения к базе данных.
     * @throws PDOException Если произошла ошибка при подключении к базе данных.
     */
    public function init(array $params = []): PDO
    {
        if (isset($this->connections[self::$dbName])) {
            return $this->connections[self::$dbName];
        }

        $settings = self::getSettings($params);

        try {
            $pdo = new PDO(
                'mysql:host=' . $settings['host'] . ';dbname=' . $settings['databaseName'] . ';charset=utf8',
                $settings['userName'],
                $settings['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=''"
                ]
            );

            $pdo->exec("set names utf8");

            $this->connections[self::$dbName] = $pdo;

            return $pdo;
        } catch (PDOException $e) {

            dd('Ошибка подключения к базе данных!');

            throw $e;
        }
    }

    /**
     * Получить настройки базы данных.
     *
     * @param array $params Параметры соединения.
     * @return array Настройки базы данных.
     */
    private static function getSettings(array $params): array
    {
        return Config::getConfig('database', self::$dbName);
    }

    /**
     * Установить поля для выборки.
     *
     * @param array $fields Массив полей для выборки.
     */
    public static function fl(array $fields): void
    {
        self::$fl = $fields;
    }

    /**
     * Выполнить запрос SQL.
     *
     * @param string $sql SQL-запрос.
     * @param array $ex Массив значений для подстановки в запрос.
     * @return PDOStatement Объект PDOStatement с результатом запроса.
     */
    public static function query(string $sql, array $ex = []): PDOStatement
    {
        $database = self::getInstance();

        $pdo = $database->init();

        $stmt = $pdo->prepare($sql);

        $stmt->execute($ex);

        return $stmt;
    }

    /**
     * Получить id последней вставленной записи
     *
     * @return int id новой записи
     */
    public static function lastInsertId(): int
    {
        $database = self::getInstance();

        $pdo = $database->init();

        return $pdo->lastInsertId();
    }

    /**
     * Выполнить SELECT-запрос к базе данных.
     *
     * @param string $table Имя таблицы.
     * @param string $sql Дополнительная часть SQL-запроса.
     * @param array $ex Массив значений для подстановки в запрос.
     * @param string $mode Режим выборки: 'list' (список) или 'one' (одна запись).
     * @return array Результат выборки.
     */
    public static function select(string $table, string $sql, array $ex = [], string $mode = 'list'): array
    {
        $database = self::getInstance();

        $pdo = $database->init();

        $fl = '*';

        if (self::$fl) {
            $fl = implode(',', self::$fl);
        }

        $stmt = $pdo->prepare("SELECT $fl FROM $table $sql");

        $stmt->execute($ex);

        $data = [];

        if ($mode === 'list') {
            $data = $stmt->fetchAll();
        } else if ($mode === 'one' || $mode === 'once') {
            $data = $stmt->fetch();
        }

        if (!$data) {
            return [];
        }

        return (array)$data;
    }
}
