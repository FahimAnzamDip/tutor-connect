<?php
function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    return $protocol . $host . $requestUri;
}

function getPageUrl() {
    $currentUrl = getCurrentUrl();
    $parsedUrl = parse_url($currentUrl, PHP_URL_PATH);
    $parsedUrl = rtrim($parsedUrl, '/');
    $pathSegments = explode('/', $parsedUrl);
    return end($pathSegments);
}
