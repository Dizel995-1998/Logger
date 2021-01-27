<?php

namespace Logger;

abstract class AbstractStorage
{
    /**
     * Конструктор всегда должен принимать конфигурационные параметры, если
     * storage в них не нуждается, необходимо передать пустой массив.
     *
     * Вся обработка за верную инициализацию Storage обьекта лежит на разработчике
     * проектирующего Storage класс
     *
     * AbstractStorage constructor.
     * @param array $config
     */
    abstract public function __construct($config = []);

    /**
     * Необходимо реализовать метод для непосредственной записи в Storage,
     * это может быть всё что угодно: файл, БД, сетевой ресурс.
     *
     * @param string $text
     */
    abstract protected function write(string $text) : void;

    /**
     * Метод производит форматирование текста лога
     * @param string $level_of_logging уровень логирования ( DEBUG, WARNING, ERROR, CRITICAL )
     * @param string $text_of_log текст самого лога
     * @return string
     */
    abstract protected function formattingText(string $level_of_logging, string $text_of_log) : string;

    /**
     * Метод производит форматирование текста лога и непосредственную запись
     * @param string $level_of_logging
     * @param string $text_of_log
     */
    public function writeLog(string $level_of_logging, string $text_of_log) : void
    {
        $this->write($this->formattingText($level_of_logging, $text_of_log));
    }
}