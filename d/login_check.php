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
    if ($login_id === $result['login_id'] && $user_pass === $result['user_pass'] && in_array($result['account_type'], $account_type)) {
        $user_name = $result['user_name'];
        $table_id = (int)$result['table_id'];
        $dbh = null;

        // ログを更新
        set_log($login_id, 0, 'login', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

        // cookieの保存
        setcookie('login_id', $login_id, time() + (60 * 60 * 24 * 60));
        setcookie('user_pass', $user_pass, time() + (60 * 60 * 24 * 60));

        header('Location: index.php?banner=0', true, 307);
        exit;
    } else {
        $sql = 'SELECT * FROM info_account';
        $stmt = $dbh->query($sql);
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        $check_account = false;
        foreach ($result2 as $row) {
            if ($row['login_id'] === $login_id) {
                $check_account = true;
                break;
            }
        }
        if ($check_account == true) {
            header('Location: login.php?banner=3', true, 307);
        } else {
            header('Location: login.php?banner=2', true, 307);
        }
    }
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
