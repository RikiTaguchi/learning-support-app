<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

// 生徒のテーブルIDを取得
$student_table_id = $_POST['student_table_id'];

// 成績情報を取得
$grade = $_POST['score_grade'];
$term = $_POST['score_term'];
$subject = $_POST['score_subject'];
$point = $_POST['score_point'];
$average = $_POST['score_average'];
$deviation = $_POST['score_deviation'];

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

    // 生徒情報を取得
    $sql = 'SELECT * FROM info_account WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $student_user_name = $result['user_name'];
    $student_login_id = $result['login_id'];
    $student_user_pass = $result['user_pass'];
    $student_account_type = $result['account_type'];
    $student_account_status = $result['account_status'];

    // 重複レコードの確認
    $sql = 'SELECT * FROM info_score WHERE table_id = :table_id AND grade = :grade AND term = :term AND subject = :subject';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->bindParam(':grade', $grade, PDO::PARAM_INT);
    $stmt->bindParam(':term', $term, PDO::PARAM_INT);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        header('Location: score_info.php?banner=25', true, 307);
        exit;
    }

    // 成績情報の登録
    $sql = 'INSERT INTO info_score VALUES(:table_id, :grade, :term, \'\', :subject, \'\', :score, :average, :deviation)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->bindParam(':grade', $grade, PDO::PARAM_INT);
    $stmt->bindParam(':term', $term, PDO::PARAM_INT);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_INT);
    $stmt->bindParam(':score', $point, PDO::PARAM_INT);
    $stmt->bindParam(':average', $average, PDO::PARAM_INT);
    $stmt->bindParam(':deviation', $deviation, PDO::PARAM_INT);
    $stmt->execute();

    $dbh = null;

    header('Location: score_info.php?banner=6', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
