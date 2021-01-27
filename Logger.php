<?php

namespace Logger;

class Logger
{
    /**
     * Хранит коллекцию обьектов Storage типа
     *
     * @var array
     */
    private $storages = [];

    /**
     * Добавляет обьект в коллекцию storages, если storage
     * с данным ключом уже находится в коллекции, выбрасывается исключение
     *
     * @param string $storageName - ключ/метка по которой в будущем
     * производится обращение к Storage обьекту для записи лога
     *
     * @param AbstractStorage $storage - обьект яв-ся наследником абстрактного класса и реализующий основные методы
     * для ведения логов
     *
     * @throws \Exception
     */
    public function addStorage(string $storageName, AbstractStorage $storage)
    {
        $storageName = strtolower($storageName);

        if (isset($this->storages[$storageName])) {
            throw new \Exception('Array of storages already consist so storage');
        }

        $this->storages[$storageName] = $storage;
    }

    /**
     * Производит запись лога используя Storage обьект
     *
     * @param string $level_of_logging - уровень логирования ( 'DEBUG', 'CRITICAL, 'ERROR' ... )
     * @param string $storageName ключ Storage обьекта по которому он хранится в коллекции
     * @param string $text_of_log текст лога
     * @throws \Exception
     */
    private function writeByStorage(string $level_of_logging, string $storageName, string $text_of_log)
    {
        $storageName = strtolower($storageName);

        if (!isset($this->storages[$storageName])) {
            throw new \Exception("Can't find storage name: " . $storageName);
        }

        $this->storages[$storageName]->writeLog($level_of_logging, $text_of_log);
    }

    /**
     * @param string $storageName
     * @param string $text_of_log
     * @throws \Exception
     */
    public function debug(string $storageName, string $text_of_log)
    {
        $this->writeByStorage('DEBUG', $storageName, $text_of_log);
    }

    /**
     * @param string $storageName
     * @param string $text_of_log
     * @throws \Exception
     */
    public function error(string $storageName, string $text_of_log)
    {
        $this->writeByStorage('ERROR', $storageName, $text_of_log);
    }

    /**
     * @param string $storageName
     * @param string $text_of_log
     * @throws \Exception
     */
    public function warning(string $storageName, string $text_of_log)
    {
        $this->writeByStorage('WARNING', $storageName, $text_of_log);
    }

    /**
     * @param string $storageName
     * @param string $text_of_log
     * @throws \Exception
     */
    public function critical(string $storageName, string $text_of_log)
    {
        $this->writeByStorage('CRITICAL', $storageName, $text_of_log);
    }
}
