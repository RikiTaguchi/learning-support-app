<?php
// ユーザー情報
$login_id = $_POST['login_id'];
$user_pass = $_POST['user_pass'];
$user_name = $_POST['user_name'];

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
