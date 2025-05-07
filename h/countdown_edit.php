<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['h'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$edit_type = $_POST['edit_type'];
try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

if ($edit_type == 'reset') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'DELETE FROM info_countdown WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $dbh = null;

        // ログを更新
        set_log($login_id, 6, 'reset', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

        header('Location: index.php?banner=8', true, 307);
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
} else {
    try {
        if (!isset($_POST['user_title']) || empty($_POST['user_title'])) {
            header('Location: countdown_set.php?banner=9', true, 307);
            exit;
        } else {
            $new_title = $_POST['user_title'];
        }
        if (!isset($_POST['user_date']) || empty($_POST['user_date'])) {
            header('Location: countdown_set.php?banner=9', true, 307);
            exit;
        } else {
            $new_date = $_POST['user_date'];
            $date_target = DateTime::createFromFormat('Y-m-d', $new_date);
            $date_today = new DateTime();
            $date_target->setTime(0, 0, 0);
            $date_today->setTime(0, 0, 0);
            if ($date_target < $date_today) {
                header('Location: countdown_set.php?banner=24', true, 307);
                exit;
            }
        }
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_countdown WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            $sql = 'INSERT INTO info_countdown VALUES(:table_id, :title, :date_limit)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':title', $new_title, PDO::PARAM_STR);
            $stmt->bindParam(':date_limit', $new_date, PDO::PARAM_STR);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $sql = 'UPDATE info_countdown SET title = :title, date_limit = :date_limit WHERE table_id = :table_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':title', $new_title, PDO::PARAM_STR);
            $stmt->bindParam(':date_limit', $new_date, PDO::PARAM_STR);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        $dbh = null;

        // ログを更新
        set_log($login_id, 6, 'set', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

        header('Location: index.php?banner=8', true, 307);
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
    }
}
