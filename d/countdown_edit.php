<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = 'd';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$edit_type = $_POST['edit_type'];
try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
    $user_countdown_title = $result['countdown_title'];
    $user_countdown_date = strtotime($result['countdown_date']);
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

if ($edit_type == 'reset') {
    try {
        $countdown_title = '';
        $conutdown_date = '0000-00-00';
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE info_account SET countdown_title = :countdown_title, countdown_date = :countdown_date WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':countdown_title', $countdown_title, PDO::PARAM_STR);
        $stmt->bindParam(':countdown_date', $conutdown_date, PDO::PARAM_STR);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $dbh = null;
        header('Location: countdown_set.php?banner=8', true, 307);
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
} else {
    try {
        if (!isset($_POST['user_title']) || empty($_POST['user_title'])) {
            $new_title = '';
        } else {
            $new_title = $_POST['user_title'];
        }
        if (!isset($_POST['user_date']) || empty($_POST['user_date'])) {
            $new_date = '0000-00-00';
        } else {
            $new_date = $_POST['user_date'];
        }
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE info_account SET countdown_title = :countdown_title, countdown_date = :countdown_date WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':countdown_title', $new_title, PDO::PARAM_STR);
        $stmt->bindParam(':countdown_date', $new_date, PDO::PARAM_STR);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $dbh = null;
        header('Location: index.php?banner=8', true, 307);
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
    }
}
