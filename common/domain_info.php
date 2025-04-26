<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // ローカル環境
    $domain = 'http://localhost/learning-support-app';
} else {
    // 本番環境
    $domain = 'https://wordsystemforstudents.com';
}
