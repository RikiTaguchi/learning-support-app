<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['h'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$new_book_name = $_POST['new_book_name'];
$book_id = $_POST['book_id'];
$state = $_POST['state'];
$question = $_POST['question'];
$answer = $_POST['answer'];

if ($state === 'new') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];

        // MyBookリストの取得
        $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 既存の参考書との重複チェック
        $i = 0;
        while ($i == 0) {
            foreach ($result as $row) {
                if ($row == null) {
                    break;
                } else if (($new_book_name == $row['book_name'] && $table_id == $row['table_id']) || in_array($new_book_name, $book_name_list)) {
                    header('Location: form4.php?banner=13', true, 307);
                    exit;
                }
            }
            break;
        }

        // book_idの生成
        $i = 0;
        while ($i == 0) {
            $book_id = rand(100000, 999999);
            $check_id = true;
            foreach ($result as $row) {
                if ((string)$book_id == $row['book_id']) {
                    $check_id = false;
                    break;
                }
            }
            if ($check_id == true) {
                break;
            }
        }

        // MyBookの追加
        $insert_data = $table_id . ', \'' . (string)$book_id . '\', \'' . $new_book_name . '\', \'\'';
        $sql = 'INSERT INTO info_my_book_index (table_id, book_id, book_name, memo) VALUES(:table_id, :book_id, :book_name, \'\')';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':book_name', $new_book_name, PDO::PARAM_STR);
        $stmt->execute();

        $dbh = null;

        // ログを更新
        set_log($login_id, 5, 'set', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

        // リダイレクト（My単語帳編集画面）
        $redirect_path = 'Location: detail.php?banner=6&book_id=' . (string)$book_id;
        header($redirect_path, true, 307);
        exit;

    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
} else {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
