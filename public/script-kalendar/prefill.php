<?php
// public/script-kalendar/prefill.php
// Скрипт для предзаполнения кеша православного календаря

set_time_limit(300); // 5 минут на выполнение

echo "=== Orthodox Calendar Cache Prefill ===\n\n";

// Предзаполняем 14 дней: 7 дней назад, сегодня, 6 дней вперёд
$daysBack = 7;
$daysForward = 6;

$successCount = 0;
$failCount = 0;

for ($offset = -$daysBack; $offset <= $daysForward; $offset++) {
    $date = date('Y-m-d', strtotime("$offset days"));
    list($year, $month, $day) = explode('-', $date);
    
    // Предзаполняем оба варианта: dt=0 (без даты в заголовке) и dt=1 (с датой)
    foreach ([0, 1] as $dt) {
        $url = "http://localhost/script-kalendar/pppr.php?month=$month&today=$day&year=$year&dt=$dt&header=1&lives=1&trp=0&scripture=0";
        
        echo "[$date dt=$dt] Fetching... ";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 30,
                'ignore_errors' => true,
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        // Проверяем HTTP статус
        $status = 'unknown';
        if (!empty($http_response_header)) {
            foreach ($http_response_header as $header) {
                if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $header, $m)) {
                    $status = $m[1];
                    break;
                }
            }
        }
        
        if ($response !== false && $status == '200') {
            echo "✓ OK (HTTP $status, ".strlen($response)." bytes)\n";
            $successCount++;
        } else {
            echo "✗ FAILED (HTTP $status)\n";
            $failCount++;
        }
        
        // Небольшая задержка между запросами
        usleep(500000); // 0.5 секунды
    }
}

echo "\n=== Summary ===\n";
echo "Success: $successCount\n";
echo "Failed: $failCount\n";
echo "Total: ".($successCount + $failCount)."\n";
echo "\nDone.\n";
