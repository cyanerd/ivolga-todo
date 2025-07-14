<?php
// Подключаем нашу систему логирования
include($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/log_helper.php");

// Тестируем различные типы логов
projectLog("Тестовое сообщение в общий лог", "general");
projectDebugLog("Отладочное сообщение", "test");
projectErrorLog("Сообщение об ошибке", "test");

echo "Тест логирования завершен.\n";
echo "Проверьте файлы в директории: " . $_SERVER['DOCUMENT_ROOT'] . "/local/log/\n";

// Показываем содержимое логов
$log_dir = $_SERVER['DOCUMENT_ROOT'] . '/local/log/';
if (is_dir($log_dir)) {
    echo "\nНайденные файлы логов:\n";
    $files = glob($log_dir . "*.log");
    foreach ($files as $file) {
        echo "  - " . basename($file) . "\n";
        if (file_exists($file)) {
            echo "    Размер: " . filesize($file) . " байт\n";
            echo "    Последние 5 строк:\n";
            $lines = file($file);
            $last_lines = array_slice($lines, -5);
            foreach ($last_lines as $line) {
                echo "      " . trim($line) . "\n";
            }
        }
    }
} else {
    echo "Директория логов не найдена: $log_dir\n";
}
?> 