<?php

// public/script-kalendar/pppr.php
header('Content-Type: text/html; charset=utf-8');

$month = intval($_GET['month'] ?? 1);
$year = intval($_GET['year'] ?? date('Y'));
$today = intval($_GET['today'] ?? date('d'));
$trp = intval($_GET['trp'] ?? 0);
$header = intval($_GET['header'] ?? 1);
$lives = intval($_GET['lives'] ?? 1);
$scripture = intval($_GET['scripture'] ?? 0);
$dt = intval($_GET['dt'] ?? 0);

$url = "http://www.holytrinityorthodox.com/ru/calendar/calendar.php?month={$month}&today={$today}&year={$year}&dt={$dt}&header={$header}&lives={$lives}&trp={$trp}&scripture={$scripture}";

// Log incoming request (helpful for debugging in prod)
logMsg("REQUEST: month={$month} today={$today} year={$year} url={$url}");

// cache/log paths
$dir = __DIR__;
$cacheDir = $dir.'/cache';
$logFile = $dir.'/pppr.log';
if (! is_dir($cacheDir)) {
    @mkdir($cacheDir, 0755, true);
}

$cacheKey = 'pppr_'.md5($url).'.html';
$cacheFile = $cacheDir.'/'.$cacheKey;
$cacheTtl = 60 * 60 * 24 * 7; // 7 дней

function logMsg($msg)
{
    global $logFile;
    $line = date('Y-m-d H:i:s').' '.$msg.PHP_EOL;
    @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}

// Log that script was invoked (will create pppr.log if writable)
logMsg("CALL: month={$month} today={$today} year={$year} url={$url}");

$contents = false;
$httpCode = 0;
$attempts = 3;
$wait = [0, 1, 2];

for ($i = 0; $i < $attempts; $i++) {
    // try cURL if available
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; pppr-proxy/1.0)',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '', // поддержать gzip/deflate
        ]);
        $contents = @curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE) ?: 0;
        $curlError = curl_error($ch);
        curl_close($ch);
        if ($curlError) {
            logMsg("cURL error: {$curlError} for URL: {$url}");
        }
    } else {
        // fallback на file_get_contents
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'header' => "User-Agent: Mozilla/5.0 (compatible; pppr-proxy/1.0)\r\n",
            ],
        ]);
        $contents = @file_get_contents($url, false, $context);
        // попытка извлечь http-код из $http_response_header
        $httpCode = 0;
        if (! empty($http_response_header)) {
            foreach ($http_response_header as $hdr) {
                if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $hdr, $m)) {
                    $httpCode = intval($m[1]);
                    break;
                }
            }
        }
    }

    // --- debug logging for each attempt ---
    $len = is_string($contents) ? strlen($contents) : 0;
    $samp = $len ? substr($contents, 0, 300) : '';
    $method = function_exists('curl_init') ? 'curl' : 'fopen';
    logMsg("ATTEMPT: i={$i} method={$method} httpCode={$httpCode} len={$len}");
    if ($len) {
        $snippet = preg_replace('/\s+/', ' ', strip_tags((string) $samp));
        // limit snippet length to 300 chars
        logMsg('SNIPPET: '.mb_substr($snippet, 0, 300));
    }
    if ($httpCode === 200 && $len > 0) {
        logMsg("SUCCESS: url={$url} attempt={$i} len={$len}");
    }

    // Если 200 и нет явной 503 в тексте — считаем успехом
    if ($httpCode === 200 && $contents !== false && stripos($contents, '503 Service Temporarily Unavailable') === false) {
        break;
    }

    // небольшой бэкофф перед повтором
    if ($i < $attempts - 1) {
        sleep($wait[$i + 1]);
    }
}

// Если получили контент — попробуем детект кодировки и конвертировать в UTF-8
if ($contents !== false && $httpCode === 200) {
    $detected = mb_detect_encoding($contents, ['UTF-8', 'Windows-1251', 'CP1251', 'ISO-8859-1'], true);
    if ($detected && stripos($detected, 'UTF') === false) {
        $contents = mb_convert_encoding($contents, 'UTF-8', $detected);
    }
    // Записываем в кеш
    @file_put_contents($cacheFile, $contents, LOCK_EX);
    echo $contents;
    exit;
}

// На ошибке: логируем и пробуем вернуть кеш
logMsg("Request failed httpCode={$httpCode} url={$url}");

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) <= $cacheTtl) {
    // вернуть кешированный ответ с небольшим предупреждением в HTML комменте
    $cached = file_get_contents($cacheFile);
    echo '<!-- Served from cache: '.date('Y-m-d H:i:s', filemtime($cacheFile))." -->\n";
    echo $cached;
    exit;
}

// Если нет кеша — вернуть понятное сообщение и HTTP 503
http_response_code(503);
echo '<p style="color:#666; text-align:center;">Сервис православного календаря временно недоступен. Попробуйте обновить страницу позже.</p>';
exit;
