<?php

namespace Logger;

class StorageFile extends AbstractStorage
{
    /**
     * Путь к директории в которой хранятся логи
     */
    CONST DIRECTORY = '';

    /**
     * Указататель на дескриптор потока работающего с файлом
     *
     * @var bool|resource
     */
    protected $pointerToFile;

    /**
     * StorageFile constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        $this->pointerToFile = fopen(self::DIRECTORY . $config['file_name'], 'a+');

        if ($this->pointerToFile == false) {
            throw new \Exception("Can't open the file " . $config['file_name']);
        }
    }

    /**
     * Реализация абстрактного метода write, в данном случае производится запись в файл
     *
     * @param string $text
     */
    protected function write(string $text) : void
    {
        fwrite($this->pointerToFile, $text);
    }

    /**
     * Форматирование текста лога
     * @param string $level_of_logging
     * @param string $text_of_log
     * @return string
     */
    protected function formattingText(string $level_of_logging, string $text_of_log) : string
    {
        return sprintf("%s [%s] %s", $level_of_logging, date("H:i:s"), $text_of_log) . PHP_EOL;
    }
}

