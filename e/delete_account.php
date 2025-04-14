<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = 'e';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    $sql = 'DELETE FROM  info_account WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'DELETE FROM info_my_book_index WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'DELETE FROM info_my_book_data WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'DELETE FROM  info_feedback WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'DELETE FROM  info_stamp WHERE user_table_id = :user_table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    $dbh = null;

    // cookieの削除
    setcookie('login_id', '', time() - 30);
    setcookie('user_pass', '', time() - 30);

    header('Location: login.php?banner=7', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
