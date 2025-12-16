<?php

header('Content-Type: text/html; charset=utf-8');

$month = $_GET['month'] ?? 1;
$year = $_GET['year'] ?? date('Y');
$today = $_GET['today'] ?? date('d');
$trp = $_GET['trp'] ?? 0;
$header = $_GET['header'] ?? 1;
$lives = $_GET['lives'] ?? 1;
$scripture = $_GET['scripture'] ?? 0;
$dt = $_GET['dt'] ?? 0;

$url = "http://www.holytrinityorthodox.com/ru/calendar/calendar.php?month=$month&today=$today&year=$year&dt=$dt&header=$header&lives=$lives&trp=$trp&scripture=$scripture";

$contents = false;

// Пробуем cURL (более надежный способ)
if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode !== 200 || $contents === false) {
        $contents = false;
    }
}

// Fallback на file_get_contents
if ($contents === false && ini_get('allow_url_fopen')) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ],
    ]);
    $contents = @file_get_contents($url, false, $context);
}

// Если не удалось получить данные
if ($contents === false) {
    echo '<p style="color: #666; text-align: center;">Не удалось загрузить данные православного календаря. Попробуйте позже.</p>';
    exit;
}

// Конвертируем из Windows-1251 в UTF-8
$contents = mb_convert_encoding($contents, 'UTF-8', 'Windows-1251');

echo $contents;
