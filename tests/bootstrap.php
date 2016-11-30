<?php

$path = implode(DIRECTORY_SEPARATOR, [
    __DIR__,
    '..',
    'vendor',
    'autoload.php',
]);

require_once $path;