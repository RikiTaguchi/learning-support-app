<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = 'j';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$table_id = $_POST['table_id'];
$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$new_memo = $_POST['new_memo'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 目次の更新
    $sql = 'UPDATE info_my_book_index SET memo = :memo WHERE table_id = :table_id AND book_id = :book_id AND book_name = :book_name';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':memo', $new_memo, PDO::PARAM_STR);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
    $stmt->bindParam(':book_name', $book_name, PDO::PARAM_STR);
    $stmt->execute();
    $dbh = null;
    header('Location: detail.php?banner=8', true, 307);
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
