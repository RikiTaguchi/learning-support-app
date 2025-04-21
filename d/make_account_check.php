<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['d'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 既存アカウントとのログインID重複をチェック
    if ($result != false) {
        $dbh = null;
        header('Location: login.php?banner=4', true, 307);
        exit;
    }

    // 既存アカウントとのテーブルID重複をチェック
    $i = 0;
    $sql = 'SELECT table_id FROM info_account';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    while ($i == 0) {
        $table_id = rand(100000, 999999);
        $check_id = true;
        foreach ($result as $row) {
            if ($table_id == $row['table_id']) {
                $check_id = false;
                break;
            }
        }
        if ($check_id == true) {
            break;
        }
    }

    // アカウントの追加
    $sql = 'INSERT INTO info_account VALUES(:user_name, :login_id, :user_pass, :table_id, \'\', \'0000-00-00\', :account_type)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_pass', $user_pass, PDO::PARAM_STR);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':account_type', $account_type[0], PDO::PARAM_STR);
    $stmt->execute();
    $dbh = null;

    // Cookieにアカウント情報を保存
    setcookie('login_id', $login_id, time() + (60 * 60 * 24 * 60));
    setcookie('user_pass', $user_pass, time() + (60 * 60 * 24 * 60));

    header('Location: login.php?banner=6', true, 307);

} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
