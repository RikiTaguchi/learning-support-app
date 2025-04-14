<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = 'h';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$table_id = $_POST['table_id'];
$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$question_number = (int)$_POST['question_number'];
$new_word = $_POST['new_word'];
$new_answer = $_POST['new_answer'];
$word = $_POST['word'];
$answer = $_POST['answer'];
$set_type = $_POST['submit'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($set_type == 'add') { // 追加
        $sql = 'INSERT INTO info_my_book_data (table_id, book_id, word, answer, question_number) VALUES(:table_id, :book_id, :word, :answer, :question_number)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':word', $new_word, PDO::PARAM_STR);
        $stmt->bindParam(':answer', $new_answer, PDO::PARAM_STR);
        $stmt->bindParam(':question_number', $question_number, PDO::PARAM_INT);
        $stmt->execute();
    } else if ($set_type == 'change') { // 更新
        $sql = 'UPDATE info_my_book_data SET word = :word, answer = :answer WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':word', $new_word, PDO::PARAM_STR);
        $stmt->bindParam(':answer', $new_answer, PDO::PARAM_STR);
        $stmt->bindParam(':question_number', $question_number, PDO::PARAM_INT);
        $stmt->execute();
    } else if ($set_type == 'delete') { // 削除
        $sql = 'DELETE FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':question_number', $question_number, PDO::PARAM_INT);
        $stmt->execute();
        $sql = 'DELETE FROM info_feedback WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':question_number', $question_number, PDO::PARAM_INT);
        $stmt->execute();
        $sql = 'SELECT * FROM info_feedback WHERE table_id = :table_id AND book_id = :book_id ORDER BY question_number';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ((int)$row['question_number'] > $question_number) {
                $question_number_pre = (int)$row['question_number'];
                $question_number_new = (int)$row['question_number'] - 1;
                $sql = 'UPDATE info_feedback SET question_number = :question_number_new WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number_pre';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
                $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
                $stmt->bindParam(':question_number_pre', $question_number_pre, PDO::PARAM_INT);
                $stmt->bindParam(':question_number_new', $question_number_new, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    } else if ($set_type == 'delete_all') { // 全削除
        $sql = 'DELETE FROM info_my_book_index WHERE table_id = :table_id AND book_id = :book_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
        $sql = 'DELETE FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
        $sql = 'DELETE FROM info_feedback WHERE table_id = :table_id AND book_id = :book_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
        $dbh = null;
        header('Location: index.php?banner=7', true, 307);
    } else { // エラー
        $dbh = null;
        header('Location: index.php?banner=9', true, 307);
    }

    // インデックスの修正
    $sql = 'SELECT * FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 1;
    foreach ($result as $row) {
        $sql = 'UPDATE info_my_book_data SET question_number = :question_number_new WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number_pre';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':question_number_new', $i, PDO::PARAM_INT);
        $stmt->bindParam(':question_number_pre', $row['question_number'], PDO::PARAM_INT);
        $stmt->execute();
        $i += 1;
    }

    $dbh = null;
    header('Location: detail.php?banner=8', true, 307);
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
