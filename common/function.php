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

// 入力範囲のエラーをチェックする関数
function check_form($book, $start, $end, $number, $limit) {
    if ($book == '' || $book == 'n') {
        return 1;
    } else if (($start >= 1 && $end <= $limit && ($end - $start + 1) >= $number && $number > 0) == false) {
        return 2;
    } else {
        return 3;
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
