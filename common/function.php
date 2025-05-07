<?php
// リンクを作成する関数
function make_link($title, $url, $info) {
    $text_form = '
        <form method = "post" action = "' . $url .'">
            <input class = "info_account" type = "text" name = "user_name" value = "' . $info[0] . '">
            <input class = "info_account" type = "text" name = "login_id" value = "' . $info[1] . '">
            <input class = "info_account" type = "text" name = "user_pass" value = "' . $info[2] . '">
            <button class = "make-link-button" type = "submit">
                <p>' . $title . '</p>
            </button>
        </form>
    ';
    echo $text_form;
}

// アカウントのタイプをチェックする関数
function check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass) {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!in_array($result['account_type'], $account_type)) {
            header('Location: login.php?banner=9', true, 307);
            exit;
        }
    } catch (Exception $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
}

// 入力範囲のエラーをチェックする関数
function check_form($book, $start, $end, $number, $limit) {
    if ($book == '' || $book == 'n') {
        return 1;
    } else if (!($start >= 1 && $end <= $limit && ($end - $start + 1) >= $number && $number > 0 && $number < 101)) {
        return 2;
    } else if ($number > 100) {
        return 3;
    } else {
        return 4;
    }
}

// 既存Bookのoptionタグを生成する関数
function set_options() {
    global $book_id_list;
    global $book_name_list;
    global $default_count;
    echo '<option value = "n" hidden>選択してください</option>' . PHP_EOL;
    for ($i = 0; $i < $default_count; $i++) {
        echo '<option value = "' . (string)($i + 1) . '">' . $book_name_list[$i] . '</option>' . PHP_EOL;
    }
}

// 既存Bookのoptionタグを生成する関数(form3.php用)
function set_options_feedback($list_feedback) {
    global $book_id_list;
    global $book_name_list;
    global $default_count;
    echo '<option value = "n" hidden>選択してください</option>' . PHP_EOL;
    for ($i = 0; $i < $default_count; $i++) {
        if (in_array($book_id_list[$i], $list_feedback)) {
            echo '<option value = "' . (string)($i + 1) . '">' . $book_name_list[$i] . '</option>' . PHP_EOL;
        }
    }
}
