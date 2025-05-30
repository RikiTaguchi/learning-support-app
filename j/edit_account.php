<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['j'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$new_login_id = $_POST['new_login_id'];
$new_user_name = $_POST['new_user_name'];
$new_user_pass = $_POST['new_user_pass'];
$new_account_status = $_POST['new_account_status'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row['login_id'] === $new_login_id) {
            if ($row['login_id'] != $login_id) {
                $dbh = null;
                header('Location: info_account.php?banner=5', true, 307);
                exit;
            }
        }
    }

    $sql = 'UPDATE info_account SET user_name = :user_name, login_id = :login_id_new, user_pass = :user_pass, account_status = :account_status WHERE login_id = :login_id_pre';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_name', $new_user_name, PDO::PARAM_STR);
    $stmt->bindParam(':user_pass', $new_user_pass, PDO::PARAM_STR);
    $stmt->bindParam(':login_id_new', $new_login_id, PDO::PARAM_STR);
    $stmt->bindParam(':account_status', $new_account_status, PDO::PARAM_STR);
    $stmt->bindParam(':login_id_pre', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $dbh = null;
    $login_id = $new_login_id;
    $user_name = $new_user_name;
    $user_pass = $new_user_pass;

    // ログを更新
    set_log($login_id, 8, 'edit', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

    // Cookieの保存
    setcookie('login_id', $login_id, time() + (60 * 60 * 24 * 60));
    setcookie('user_pass', $user_pass, time() + (60 * 60 * 24 * 60));

    header('Location: info_account.php?banner=8', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
