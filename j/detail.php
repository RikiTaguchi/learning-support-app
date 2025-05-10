<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['j'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

try {
    $book_id = $_POST['book_id'];

    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    $sql = 'SELECT * FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $next_question_number = 1;
    foreach ($result as $row) {
        $next_question_number += 1;
    }

    $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id AND book_id = :book_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->execute();
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $book_name = $result2['book_name'];

    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "My単語帳編集ページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/detail.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.1"></script>
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
        <script src = "../common/js/check-submit.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <?php
                echo '<div class = "detail-form">';
                    echo '<form method = "post" action = "detail_set3.php" autocomplete="off">';
                        echo '<p class = "detail-form-title">単語帳名</p>';
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        echo '<input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">';
                        echo '<input class = "info_account" type = "text" name = "book_name" value = "' . $book_name . '">';
                        echo '<input class = "info_account" type = "text" name = "book_id" value = "' . $book_id . '">';
                        echo '<div class = "form-block-1">';
                            echo '<input type = "text" name = "new_book_name" value = "' . $book_name . '" required>';
                            echo '<button type = "submit" name = "submit" value = "update"><p>更新</p></button>';
                        echo '</div>';
                    echo '</form>';
                echo '</div>';
                echo '<div class = "detail-form">';
                    echo '<form method = "post" action = "detail_set2.php" autocomplete="off">';
                        echo '<p class = "detail-form-title">目次</p>';
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        echo '<input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">';
                        echo '<input class = "info_account" type = "text" name = "book_name" value = "' . $book_name . '">';
                        echo '<input class = "info_account" type = "text" name = "book_id" value = "' . $book_id . '">';
                        echo '<div class = "form-block-1">';
                            echo '<textarea name = "new_memo" required>' . $result2['memo'] . '</textarea>';
                            echo '<button type = "submit" name = "submit"><p>更新</p></button>';
                        echo '</div>';
                    echo '</form>';
                echo '</div>';
                echo '<div class = "detail-form">';
                    echo '<div class = "form-block-2">';
                        echo '<table>';
                            echo '<tr>';
                                echo '<th></th>';
                                echo '<th>Word</th>';
                                echo '<th>Answer</th>';
                                echo '<th></th>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<form method = "post" action = "detail_set.php" autocomplete="off">';
                                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                    echo '<input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">';
                                    echo '<input class = "info_account" type = "text" name = "book_name" value = "' . $book_name . '">';
                                    echo '<input class = "info_account" type = "text" name = "book_id" value = "' . $book_id . '">';
                                    echo '<input class = "info_account" type = "text" name = "question_number" value = "' . (string)$next_question_number . '">';
                                    echo '<td class = "form-td-title">New</td>';
                                    echo '<td class = "form-td-element"><input type = "text" name = "new_word" required></td>';
                                    echo '<td class = "form-td-element"><input type = "text" name = "new_answer" required></td>';
                                    echo '<td class = "form-td-last">';
                                        echo '<button class = "form-button-add" type = "submit" name = "submit" value = "add"><p>追加</p></button>';
                                    echo '</td>';
                                echo '</form>';
                            echo '</tr>';
                            foreach ($result as $row) {
                                echo '<tr>';
                                    $text_form = '
                                        <form method = "post" action = "detail_set.php" autocomplete="off">
                                            <input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">
                                            <input class = "info_account" type = "text" name = "book_name" value = "' . $book_name . '">
                                            <input class = "info_account" type = "text" name = "book_id" value = "' . $book_id . '">
                                            <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                            <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                            <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                            <td class = "form-td-title">' .
                                                $row['question_number'] . 
                                                '<input class = "info_account" type = "text" name = "question_number" value = "' . $row['question_number'] . '">
                                            </td>
                                            <td class = "form-td-element">
                                                <input type = "text" name = "new_word" value = "' . $row['word'] . '" required>
                                            </td>
                                            <td class = "form-td-element">
                                                <input type = "text" name = "new_answer" value = "' . $row['answer'] . '" required>
                                            </td>
                                            <td class = "form-td-last">
                                                <button class = "form-button-change" type = "submit" name = "submit" value = "change">
                                                    <p>更新</p>
                                                </button>
                                                <button class = "form-button-delete" type = "submit" name = "submit" value = "delete">
                                                    <p>削除</p>
                                                </button>
                                            </td>
                                        </form>
                                    ';
                                    echo $text_form;
                                echo '</tr>';
                            }
                        echo '</table>';
                    echo '</div>';
                echo '</div>';
                echo '<div class = "detail-form">';
                    $text_form = '
                        <form class = "form-delete" method = "post" action = "detail_set.php" onSubmit = "return checkSubmit()" autocomplete="off">
                            <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                            <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                            <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                            <input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">
                            <input class = "info_account" type = "text" name = "book_name" value = "' . $book_name . '">
                            <input class = "info_account" type = "text" name = "book_id" value = "' . $book_id . '">
                            <button type = "submit" name = "submit" value = "delete_all">
                                <p>
                                    単語帳を削除
                                </p>
                            </button>
                        </form>
                    ';
                    echo $text_form;
                echo '</div>';
                ?>
            </div>

            <div style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
