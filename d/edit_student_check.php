<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

// 生徒情報（更新後）
$student_user_name = $_POST['student_user_name'];
$student_login_id = $_POST['student_login_id'];
$student_user_pass = $_POST['student_user_pass'];
$student_account_type = $_POST['student_account_type'];
$student_account_status = $_POST['student_account_status'];

// 生徒情報（固定値）
$student_table_id = $_POST['student_table_id'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 管理者のテーブルIDを取得
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    // 既存アカウントとのログインID重複をチェック
    $sql = 'SELECT * FROM info_account';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row['login_id'] === $student_login_id) {
            if ($row['table_id'] != $student_table_id) {
                $dbh = null;
                header('Location: edit_student.php?banner=5', true, 307);
                exit;
            }
        }
    }

    // レコードの更新
    $sql = 'UPDATE info_account SET user_name = :user_name, login_id = :login_id, user_pass = :user_pass, account_type = :account_type, account_status = :account_status WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_name', $student_user_name, PDO::PARAM_STR);
    $stmt->bindParam(':user_pass', $student_user_pass, PDO::PARAM_STR);
    $stmt->bindParam(':login_id', $student_login_id, PDO::PARAM_STR);
    $stmt->bindParam(':account_type', $student_account_type, PDO::PARAM_STR);
    $stmt->bindParam(':account_status', $student_account_status, PDO::PARAM_STR);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->execute();

    $dbh = null;

    // ログを更新
    set_log($student_login_id, 10, 'edit', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

    header('Location: info_student.php?banner=8', true, 307);

} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
