<?php

require_once './vendor/autoload.php';

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

echo "100000 times\r\n";
$start = microtime(true);

$bf = new \Sysatom\BloomFilter(100000, 7);
for ($i = 1; $i <= 100000; $i++) {
    $bf->add("$i");
}

$end = microtime(true);
printf("Total time: %s s\r\nMemory Used (current): %s\r\nMemory Used (max): %s", round($end - $start, 4), formatBytes(memory_get_usage()), formatBytes(memory_get_peak_usage()));
