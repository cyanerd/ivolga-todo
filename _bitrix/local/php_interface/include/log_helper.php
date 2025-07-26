<?php
/**
 * Функция для логирования сообщений в проекте
 * @param string $message Сообщение для записи в лог
 * @param string $category Категория лога (по умолчанию 'general')
 */
function projectLog($message, $category = 'general')
{
  $log_dir = $_SERVER['DOCUMENT_ROOT'] . '/local/log/';

  // Создаем директорию, если её нет
  if (!is_dir($log_dir)) {
    mkdir($log_dir, 0755, true);
  }

  $log_file = $log_dir . $category . '_' . date('Y-m-d') . '.log';
  $timestamp = date('Y-m-d H:i:s');
  $log_message = "[{$timestamp}] [{$category}] {$message}" . PHP_EOL;

  file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
}

/**
 * Функция для логирования ошибок
 * @param string $message Сообщение об ошибке
 * @param string $context Контекст ошибки
 */
function projectErrorLog($message, $context = '')
{
  $context_info = $context ? " [{$context}]" : '';
  projectLog("ERROR: {$message}{$context_info}", 'errors');
}

/**
 * Функция для логирования отладочной информации
 * @param string $message Отладочное сообщение
 * @param string $context Контекст
 */
function projectDebugLog($message, $context = '')
{
  $context_info = $context ? " [{$context}]" : '';
  projectLog("DEBUG: {$message}{$context_info}", 'debug');
}

?>
