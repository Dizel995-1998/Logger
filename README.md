# Logger
Логгер с возможностью записи в файловую систему, БД, на сторонние сервисы. 

Пример работы с логгером:
<pre>
<code>
$logger = new Logger();

$logger->addStorage('telegram', StorageTelegram([
    'chat_id' => 'There is your chat_id',
    'telegram_token' => 'There is your telegram token'
]));

$logger->addStorage('file', new StorageFile(['file_name' => 'logs.txt']));

$logger->debug('file', 'test');
$logger->warning('telegram', 'Hello World');
</code>
</pre>

Logger - представляет собой обьект хранящий коллекцию обьектов Storage типа, обьекты добавляются в коллекцию 
через метод addStorage, обьекты передаваемые через эти методы должны быть наследниками класса AbstractStorage и реализовать методы
write и formattingText. 
