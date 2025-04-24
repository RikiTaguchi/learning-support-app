<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // ローカル環境
    $db_user = 'root';
    $db_pass = '';
    $db_host = 'localhost';
    $db_name = 'wordsystemdb';
} else {
    // 本番環境
    $db_user = 'xs192380_wsystem';
    $db_pass = 'wordsystem';
    $db_host = 'localhost';
    $db_name = 'xs192380_wsystem';
}
