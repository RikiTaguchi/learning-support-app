<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$book_name = $_GET['book_name'];
$book_id = $_GET['book_id'];
$start = $_GET['start'];
$end = $_GET['end'];
$questions_num = $_GET['questions_num'];
$number = [];
$words = [];
$answers = [];
$select1 = [];
$select2 = [];
$select3 = [];
$select4 = [];

for ($i = 1; $i <= $questions_num; $i++) {
    $data_key = 'data' . $i;
    $number[] = $_GET[$data_key];
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    
    foreach ($number as $n) {
        if (array_search($book_id, $book_id_list) === false) {
            $sql = 'SELECT * FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
            $stmt->bindParam(':question_number', $n, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql = 'SELECT * FROM ' . $book_id . ' WHERE id = :id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $n, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $words[] = $result['word'];
        $answers[] = $result['answer'];
        if ($book_id == 'Vintage') {
            $select1[] = $result['select1'];
            $select2[] = $result['select2'];
            $select3[] = $result['select3'];
            $select4[] = $result['select4'];
        }
    }
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
    <meta name = "description" content = "テスト(解答)">
    <meta name = "viewport" content = "width=device-width">
    <link href = "../common/css/answer.css?v=1.0.1" rel = "stylesheet">
    <link href = "../common/css/answer_print.css?v=1.0.0" rel = "stylesheet" media = "print">
    <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
    <link rel = "manifest" href = "../common/icons/manifest.json">
    <link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
    <link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
    <link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
    <link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
    <meta name="theme-color" content="#ffffff">
    <script src = "../common/js/disable-form.js?v=1.0.0"></script>
</head>
<body>
    <header class = "header">
        <?php
        echo '<form class = "header-top" method = "post" action = "index.php">';
            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
            echo '<button class = "header-logo" type = "submit">';
                echo '<img src = "../common/images/meiko-logo.png" alt = "ロゴ画像">';
            echo '</button>';
        echo '</form>';
        echo '<div class = "header-inner-menu">' . PHP_EOL;
        echo '<p class = "header-inner-menu-title">' . $book_name . ' / #' . $start . '~' . $end . ' / ' . $questions_num . '題</p>'. PHP_EOL;
        echo '<div class = "header-inner-menu-button">';
            echo '<form class = "form2" method = "post" action = "question.php?book_name=' . $book_name . '&book_id=' . $book_id . '&start=' . $start . '&end=' . $end . '&questions_num=' . $questions_num . '&';
            for ($i = 1; $i <= $questions_num; $i++) {
                echo 'data' . $i . '=' . $number[$i - 1];
                if ($i < $questions_num) {
                    echo '&';
                }
                else {
                    echo '">';
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<button class = "make-link-button" type = "submit">';
                        echo '<p>問題</p>';
                    echo '</button>';
                    echo '</form>';
                }
            }
            echo '<form>';
                echo '<button type = "button" onclick="window.print()">';
                    echo '<p>印刷</p>';
                echo '</button>';
            echo '</form>';
            $back_form = '
                <form class = "form2" method = "post" action = "form.php">
                    <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                    <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                    <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                    <button class = "make-link-button" type = "submit">
                        <p>戻る</p>
                    </button>
                </form>
            ';
            echo $back_form;
            echo '</div>';
        echo '</div>';
        ?>
    </header>
    <main>
        <div class = "main-inner">
        <?php
        for ($i = 0; $i < $questions_num; $i++) {
            if (($i + 1) % 10 == 0) {
                echo '<p class = "main-inner-word-change">';
            } else {
                echo '<p class = "main-inner-word">';
            }
            $answers[$i] = str_replace('<br>', ',　', $answers[$i]);
            $answers[$i] = str_replace('<font size = "0">', '<font>', $answers[$i]);
            $answers[$i] = str_replace('<font size = "1">', '<font>', $answers[$i]);
            $answers[$i] = str_replace('<font size = "2">', '<font>', $answers[$i]);
            $answers[$i] = str_replace('<font size = "3">', '<font>', $answers[$i]);
            $answers[$i] = str_replace('<font size = "4">', '<font>', $answers[$i]);
            $answers[$i] = str_replace('<font size = "5">', '<font>', $answers[$i]);
            $answers[$i] = str_replace('<font size = "6">', '<font>', $answers[$i]);
            $answers[$i] = str_replace('<font size = "7">', '<font>', $answers[$i]);
            echo $i + 1 . '.　　' . $answers[$i] . ' (' . $number[$i] . ')<br>';
            echo '</p>';
        }
        ?>
        </div>
    </main>
</body>
</html>
