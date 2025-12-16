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

// cache/log paths
$dir = __DIR__;
$cacheDir = $dir.'/cache';
$logFile = $dir.'/pppr.log';
if (! is_dir($cacheDir)) {
    @mkdir($cacheDir, 0755, true);
}

// Log incoming request (helpful for debugging in prod) — move after paths are initialized
logMsg("REQUEST: month={$month} today={$today} year={$year} url={$url}");

// Create cache key from meaningful parameters only (ignore sid and other random params)
$cacheKeyString = "m{$month}_d{$today}_y{$year}_dt{$dt}_h{$header}_l{$lives}_t{$trp}_s{$scripture}";
$cacheKey = 'pppr_'.md5($cacheKeyString).'.html';
$cacheFile = $cacheDir.'/'.$cacheKey;
$cacheTtl = 60 * 60 * 24 * 30; // 30 дней

function logMsg($msg)
{
    global $logFile;
    // safety: do not attempt to write if log path not set
    if (empty($logFile)) {
        return;
    }

    // ensure directory is writable
    $logDir = dirname($logFile);
    if (! is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }

    $line = date('Y-m-d H:i:s').' '.$msg.PHP_EOL;
    @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}

// Log that script was invoked (will create pppr.log if writable)
logMsg("CALL: month={$month} today={$today} year={$year} url={$url}");

// Check if cache exists and is valid first (before making external request)
if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) <= $cacheTtl) {
    logMsg('CACHE HIT: serving from cache file (age: '.(time() - filemtime($cacheFile)).' sec)');
    $cached = file_get_contents($cacheFile);
    echo $cached;
    exit;
}

$contents = false;
$httpCode = 0;
$attempts = 5; // увеличено с 3 до 5
$wait = [0, 2, 4, 6, 10]; // более агрессивный бэкофф

for ($i = 0; $i < $attempts; $i++) {
    // try cURL if available
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15, // увеличено с 10 до 15
            CURLOPT_CONNECTTIMEOUT => 8, // увеличено с 5 до 8
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

// На ошибке: логируем и пробуем вернуть старый кеш (даже если просрочен)
logMsg("Request failed httpCode={$httpCode} url={$url}");

// Сначала пробуем вернуть актуальный кеш (в пределах TTL)
if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) <= $cacheTtl) {
    logMsg('FALLBACK: serving valid cache (age: '.(time() - filemtime($cacheFile)).' sec)');
    $cached = file_get_contents($cacheFile);
    echo '<!-- Served from cache (fallback): '.date('Y-m-d H:i:s', filemtime($cacheFile))." -->\n";
    echo $cached;
    exit;
}

// Если нет актуального кеша, но есть старый — отдаём его (лучше старые данные, чем ошибка)
if (file_exists($cacheFile)) {
    logMsg('FALLBACK: serving STALE cache (age: '.(time() - filemtime($cacheFile)).' sec)');
    $cached = file_get_contents($cacheFile);
    echo '<!-- Served from STALE cache: '.date('Y-m-d H:i:s', filemtime($cacheFile))." -->\n";
    echo $cached;
    exit;
}

// Если вообще нет кеша — вернуть понятное сообщение и HTTP 503
logMsg('ERROR: no cache available, returning 503');
http_response_code(503);
echo '<p style="color:#666; text-align:center;">Сервис православного календаря временно недоступен. Попробуйте обновить страницу позже.</p>';
exit;
