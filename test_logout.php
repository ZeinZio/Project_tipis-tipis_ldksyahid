<?php

$cookieFile = __DIR__ . '/cookie.txt';

// 1. GET /login to get CSRF token and session cookie
$ch = curl_init('http://localhost:8080/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$html = curl_exec($ch);
curl_close($ch);

preg_match('/<meta name="csrf-token" content="(.*?)">/', $html, $matches);
$csrfToken = $matches[1] ?? '';
echo "CSRF Token: $csrfToken\n";

if (!$csrfToken) {
    die("Could not find CSRF token\n");
}

// 2. POST /login
$ch = curl_init('http://localhost:8080/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken,
    'email' => 'developerzeinzio@ldksyahid.com', // Admin account
    'password' => 'ldksyahid123'
]));
$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
echo "POST /login HTTP code: " . $info['http_code'] . "\n";

// 3. POST /logout
$ch = curl_init('http://localhost:8080/logout');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken
]));
$start = microtime(true);
$response = curl_exec($ch);
$info = curl_getinfo($ch);
$time = microtime(true) - $start;
curl_close($ch);
echo "POST /logout HTTP code: " . $info['http_code'] . " (took $time seconds)\n";
