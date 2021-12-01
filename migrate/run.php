<?php

$config = require '../application/config/db.php';

$config['versions'] = 'versions';
 
// Подключаемся к базе данных
function connectDB() {
    $errorMessage = 'Невозможно подключиться к серверу базы данных';
    $conn = new mysqli($config['host'], $config['user'], $config['password'], $config['name']);
    if (!$conn)
        throw new Exception($errorMessage);
    else {
        $query = $conn->query('set names utf8');
        if (!$query)
            throw new Exception($errorMessage);
        else
            return $conn;
    }
}
 
// Получаем список файлов для миграций
function getMigrationFiles($conn) {

    // Находим папку с миграциями
    $sqlFolder = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
    // Получаем список всех sql-файлов
    $allFiles = glob($sqlFolder . '*.sql');
 
    // Проверяем, есть ли таблица versions 
    // Так как versions создается первой, то это равносильно тому, что база не пустая
    $query = sprintf('show tables from `%s` like "%s"', $config['name'], $config['versions']);
    $data = $conn->query($query);
    $firstMigration = !$data->num_rows;
     
    // Первая миграция, возвращаем все файлы из папки sql
    if ($firstMigration) {
        return $allFiles;
    }
 
    // Ищем уже существующие миграции
    $versionsFiles = array();

    // Выбираем из таблицы versions все названия файлов
    $query = sprintf('select `name` from `%s`', $config['versions']);
    $data = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

    // Загоняем названия в массив $versionsFiles
    // Не забываем добавлять полный путь к файлу
    foreach ($data as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }
 
    // Возвращаем файлы, которых еще нет в таблице versions
    return array_diff($allFiles, $versionsFiles);
}
 
// Накатываем миграцию файла
function migrate($conn, $file) {
    // Формируем команду выполнения mysql-запроса из внешнего файла
    $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s', $config['user'], $config['password'], $config['host'], $config['name'], $file);    
    // Выполняем shell-скрипт
    shell_exec($command);
 
    // Вытаскиваем имя файла, отбросив путь
    $baseName = basename($file);
    // Формируем запрос для добавления миграции в таблицу versions
    $query = sprintf('insert into `%s` (`name`) values("%s")', $config['versions'], $baseName);
    // Выполняем запрос
    $conn->query($query);
}



// Стартуем
 
// Подключаемся к базе
$conn = connectDB();
 
// Получаем список файлов для миграций за исключением тех, которые уже есть в таблице versions
$files = getMigrationFiles($conn);
 
// Проверяем, есть ли новые миграции
if (empty($files)) {
    echo 'Ваша база данных в актуальном состоянии.';
} else {
    echo 'Начинаем миграцию...<br><br>';
 
    // Накатываем миграцию для каждого файла
    foreach ($files as $file) {
        migrate($conn, $file);
        // Выводим название выполненного файла
        echo basename($file) . '<br>';
    }
 
    echo '<br>Миграция завершена.';    
}

?>