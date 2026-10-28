<?php

// Router for the PHP built-in server used by HttpRequestTest.

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/redirect/v4/account') {
    header('Location: /v4/account', true, 302);
    return;
}

file_put_contents(getenv('SMTPSDK_TEST_LOG'), $_SERVER['REQUEST_METHOD'] . ' ' . $path . "\n", FILE_APPEND);
header('Content-Type: application/json');
echo '{"status":"success","data":{"method":"' . $_SERVER['REQUEST_METHOD'] . '"}}';
