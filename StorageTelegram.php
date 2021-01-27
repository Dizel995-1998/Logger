<?php

namespace Logger;

class StorageTelegram extends AbstractStorage
{
    protected string $telegramToken;
    protected string $chat_id;

    /**
     * Конструктор всегда должен принимать конфигурационные параметры, если
     * storage в них не нуждается, необходимо передать пустой массив.
     *
     * Вся обработка за верную инициализацию Storage обьекта лежит на Storage
     *
     * AbstractStorage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!isset($config['telegram_token'])) {
            throw new \Exception("Config must consist telegram token");
        }

        if (!isset($config['chat_id'])) {
            throw new \Exception("Config must consist chat id key");
        }

        $this->chat_id = $config['chat_id'];
        $this->telegramToken = $config['telegram_token'];
    }

    /**
     * Необходимо реализовать метод для непосредственной записи в Storage,
     * это может быть всё что угодно: файл, БД, сетевой ресурс.
     *
     * @param string $text
     */
    protected function write(string $text): void
    {
        $query = sprintf("https://api.telegram.org/bot%s/sendMessage?chat_id=%s&text=%s", $this->telegramToken, $this->chat_id, urlencode($text));
        file_get_contents($query);
    }

    /**
     * Метод производит форматирование текста лога
     * @param string $level_of_logging уровень логирования ( DEBUG, WARNING, ERROR, CRITICAL )
     * @param string $text_of_log текст самого лога
     * @return string
     */
     protected function formattingText(string $level_of_logging, string $text_of_log) : string
     {
         return sprintf("%s Time: [%s] %s", $level_of_logging, date("H:i:s"), $text_of_log);
     }

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