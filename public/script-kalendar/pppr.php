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

$contents = file_get_contents($url);

// Конвертируем из Windows-1251 в UTF-8
$contents = mb_convert_encoding($contents, 'UTF-8', 'Windows-1251');

echo $contents;
