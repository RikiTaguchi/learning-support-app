<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // 本番環境
    $domain = 'https://wordsystemforstudents.com';
} else {
    // ローカル環境
    $domain = 'http://localhost/learning-support-app';
}
