<?php
include('./source.php');

$table_id = $_POST['table_id'];
$my_book_name = $_POST['my_book_name'];
$my_book_id = $_POST['my_book_id'];
$my_table_id = $table_id . '_' . $my_book_id;

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM ' . $table_id . '_my_book_list WHERE book_id = \'' . $my_book_id . '\'';
    $stmt = $dbh->query($sql);
    $result3 = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

$i = 1;
$j = 1;
try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM ' . $my_table_id;
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($result as $row) {
        $j += 1;
    }

    $sql = 'SELECT * FROM ' . $table_id . '_my_book_list WHERE book_id = \'' . $my_book_id . '\'';
    $stmt = $dbh->query($sql);
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);

    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

include('./banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>My単語帳</title>
        <meta name = "description" content = "My単語帳編集ページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/detail.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
        <script src = "./js/set-banner.js"></script>
        <script src = "./js/check-submit.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php
            include('./header.php');
            ?>
        </header>
        <main class = "main">
            <?php if ($login_id != '000000') { ?>
            <div class = "main-inner">
                <?php
                echo '<p class = "main-inner-mybook">' . $result3['book_name'] . '</p>';
                echo '<div class = "main-inner-form-change">';
                echo '<form class = "main-inner-change-bookname" method = "post" action = "detail_set3.php">';
                    echo '<p class = "main-inner-change-title">単語帳名</p>';
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">';
                    echo '<input class = "info_account" type = "text" name = "my_book_name" value = "' . $my_book_name . '">';
                    echo '<input class = "info_account" type = "text" name = "my_book_id" value = "' . $my_book_id . '">';
                    echo '<input class = "main-inner-bookname-change" type = "text" name = "new_book_name" value = "' . $result2['book_name'] . '" required>';
                    echo '<input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">';
                    echo '<button class = "bookname_change" type = "submit" name = "submit"><p>変更</p></button>';
                echo '</form>';
                echo '</div>';

                echo '<hr class = "main-divide-area">';

                echo '<div class = "main-table-inner">';
                    if ($my_book_name != '') {
                        echo '<table>';
                            echo '<tr>';
                                echo '<th class = "main-table-th">　</th>';
                                echo '<th class = "main-table-th">Word</th>';
                                echo '<th class = "main-table-th">Answer</th>';
                                $text_form = '
                                    <th class = "main-table-th-button" colspan = "2" rowspan = "1">
                                    <form method = "post" action = "detail_set.php" onSubmit = "return checkSubmit()">
                                    <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                    <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                    <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                    <input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">
                                    <input class = "info_account" type = "text" name = "my_book_name" value = "' . $my_book_name . '">
                                    <input class = "info_account" type = "text" name = "my_book_id" value = "' . $my_book_id . '">
                                    <input class = "info-banner" type = "text" name = "info_banner" value = "delete" style = "display: none;">
                                    <button type = "submit" name = "submit" value = "delete_all">
                                        <p>
                                            単語帳を削除
                                        </p>
                                    </button>
                                    </form>
                                    </th>
                                ';
                                echo $text_form;
                            echo '</tr>';

                            echo '<tr>';
                                echo '<form method = "post" action = "detail_set.php">';
                                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                echo '<input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">';
                                echo '<input class = "info_account" type = "text" name = "my_book_name" value = "' . $my_book_name . '">';
                                echo '<input class = "info_account" type = "text" name = "my_book_id" value = "' . $my_book_id . '">';
                                echo '<input class = "info_account" type = "text" name = "my_book_question_num" value = "' . $j . '">';
                                echo '<td class = "main-table-new">New</td>';
                                echo '<td class = "main-table-new"><input type = "text" name = "new_word" required></td>';
                                echo '<td class = "main-table-new"><input type = "text" name = "new_answer" required></td>';
                                echo '<td class = "main-table-new-button" colspan = "2" rowspan = "1">';
                                    echo '<input class = "info-banner" type = "text" name = "info_banner" value = "add-data" style = "display: none;">';
                                    echo '<button type = "submit" name = "submit" value = "add"><p>追加</p></button>';
                                echo '</td>';
                                echo '</form>';
                            echo '</tr>';

                            foreach ($result as $row) {
                                echo '<tr>';
                                    $text_form = '
                                        <form method = "post" action = "detail_set.php">
                                        <input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">
                                        <input class = "info_account" type = "text" name = "my_book_name" value = "' . $my_book_name . '">
                                        <input class = "info_account" type = "text" name = "my_book_id" value = "' . $my_book_id . '">
                                        <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                        <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                        <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                        <td class = "main-table-element">' .
                                            $i . 
                                            '<input class = "info_account" type = "text" name = "my_book_question_num" value = "' . (string)$i . '">
                                        </td>
                                        <td class = "main-table-element">
                                            <input type = "text" name = "new_word" value = "' . $row['word'] . '" required>
                                        </td>
                                        <td class = "main-table-element">
                                            <input type = "text" name = "new_answer" value = "' . $row['answer'] . '" required>
                                        </td>
                                        <td class = "main-table-element-change">
                                            <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">
                                            <button type = "submit" name = "submit" value = "change">
                                            <p>
                                                変更
                                            </p>
                                            </button>
                                        </td>
                                        <td class = "main-table-element-delete">
                                            <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">
                                            <button type = "submit" name = "submit" value = "delete">
                                            <p>
                                                削除
                                            </p>
                                            </button>
                                        </td>
                                        </form>
                                    ';
                                    echo $text_form;
                                echo '</tr>';
                                $i += 1;
                            }
                        echo '</table>';
                    } else {
                        header('Location: https://wordsystemforstudents.com/error.php?type=12', true, 307);
                        exit;
                    }
                echo '</div>';

                echo '<hr class = "main-divide-area">';
                
                echo '<div class = "main-inner-form-index">';
                echo '<form class = "main-inner-add-index" method = "post" action = "detail_set2.php">';
                    echo '<p class = "main-inner-add-title">メモ</p>';
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">';
                    echo '<input class = "info_account" type = "text" name = "my_book_name" value = "' . $my_book_name . '">';
                    echo '<input class = "info_account" type = "text" name = "my_book_id" value = "' . $my_book_id . '">';
                    echo '<input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">';
                    echo '<textarea class = "new_index" name = "new_index" required>' . $result2['book_index'] . '</textarea><br>';
                    echo '<button class = "index_add" type = "submit" name = "submit"><p>更新</p></button>';
                echo '</form>';
                echo '<p class = "main-inner-form-text">※メモ欄の内容は、目次として各機能の入力画面で表示されます。</p>';
                echo '</div>';
                ?>
            </div>
            <?php
            } else {
                echo '<p>ゲストモードでは復習機能・My単語帳機能・AIサポート機能を利用できません。</p>';
            }
            ?>
        </main>
        <footer class = "footer">
            <?php
            include('./footer.php');
            ?>
        </footer>
    </body>
</html>