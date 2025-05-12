<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$student_user_name = $_POST['student_user_name'];
$student_login_id = $_POST['student_login_id'];
$student_user_pass = $_POST['student_user_pass'];
$student_account_type = $_POST['student_account_type'];

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
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $student_login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result != false) {
        $dbh = null;
        header('Location: make_student.php?banner=4', true, 307);
        exit;
    }

    // 生徒のテーブルIDを生成
    $i = 0;
    $sql = 'SELECT table_id FROM info_account';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    while ($i == 0) {
        $student_table_id = rand(100000, 999999);
        $check_id = true;
        foreach ($result as $row) {
            if ($student_table_id == $row['table_id']) {
                $check_id = false;
                break;
            }
        }
        if ($check_id == true) {
            break;
        }
    }

    // アカウントの追加
    $sql = 'INSERT INTO info_account VALUES(:user_name, :login_id, :user_pass, :table_id, :account_type, :class_id)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_name', $student_user_name, PDO::PARAM_STR);
    $stmt->bindParam(':login_id', $student_login_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_pass', $student_user_pass, PDO::PARAM_STR);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->bindParam(':account_type', $student_account_type, PDO::PARAM_STR);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    $dbh = null;

    // ログを更新
    set_log($student_login_id, 10, 'set', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

    header('Location: info_student.php?banner=6', true, 307);

} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
