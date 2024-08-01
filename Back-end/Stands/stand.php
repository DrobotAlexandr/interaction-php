<?php

if (php_sapi_name() !== 'cli') {
    return;
}

if (isset($argv[1])) {
    $standName = trim($argv[1]);
} else {
    $standName = '';
}

if (!$standName) {
    echo 'Set Stand Name!';
    return;
}

require __DIR__ . '/../Boot/Boot.php';

function getPhpFiles(string $directory): array
{
    $phpFiles = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile() and $fileInfo->getExtension() === 'php' and $fileInfo->getFilename() != 'stand.php') {
            $phpFiles[] = $fileInfo->getPathname();
        }
    }
    return $phpFiles;
}

$phpFiles = getPhpFiles(__DIR__);

$GLOBALS['STAND_NAME'] = $standName;
foreach ($phpFiles as $file) {
    include $file;
}
echo 'Stand Not Fond!';
