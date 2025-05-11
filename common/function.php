<?php
// リンクを作成する関数（メニューバー用）
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

// リンクを作成する関数（画面内用）
function make_link2($title, $url, $info) {
    $text_form = '
        <form class = "main-block-back-button" method = "post" action = "' . $url .'">
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
        if (!($start >= 1 && $end <= $limit && ($end - $start + 1) >= $number && $number > 0)) {
            return 2;
        } else {
            return 3;
        }
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

// ログをDBに記録する関数
function set_log($login_id, $log_code, $log_detail, $log_date, $db_host, $db_name, $db_user, $db_pass) {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // テーブルIDの取得
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];

        // 日時をJSTに変換
        if ($_SERVER['SERVER_NAME'] === 'localhost') {
            // ローカル環境
            $log_date = new DateTime($log_date, new DateTimeZone('Europe/Berlin'));
        } else {
            // 本番環境
            $log_date = new DateTime($log_date, new DateTimeZone('Asia/Tokyo'));
        }
        $log_date->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $log_date = $log_date->format('Y-m-d H:i:s');

        // ログの更新
        $sql = 'INSERT INTO info_analysis VALUES(:table_id, :log_code, :log_detail, :log_date)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':log_code', $log_code, PDO::PARAM_INT);
        $stmt->bindParam(':log_detail', $log_detail, PDO::PARAM_STR);
        $stmt->bindParam(':log_date', $log_date, PDO::PARAM_STR);
        $stmt->execute();
        $dbh = null;
    } catch (Exception $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
}

// ストリークを取得する関数
function get_streak($login_id, $db_host, $db_name, $db_user, $db_pass) {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // テーブルIDの取得
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];
    
        // ログイン記録の取得
        $sql = 'SELECT * FROM info_analysis WHERE table_id = :table_id AND log_code = 0 ORDER BY log_date DESC';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // 当日分のログイン記録をチェック
        $timezone = new DateTimeZone('Asia/Tokyo');
        $datetime = new DateTime('now', $timezone);
        $date_today = $datetime->format('Y-m-d');
        if (substr($result[0]['log_date'], 0, 10) != $date_today) {
            $dbh = null;
            set_log($login_id, 0, 'login', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);
            $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM info_analysis WHERE table_id = :table_id AND log_code = 0 ORDER BY log_date DESC';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // ストリークの計算
        $login_streak_result = 1;
        foreach ($result as $i => $row) {
            if ($i === count($result) - 1) {
                break;
            }
            $date_before = DateTime::createFromFormat('Y-m-d', substr($result[$i + 1]['log_date'], 0, 10));
            $date_after = DateTime::createFromFormat('Y-m-d', substr($result[$i]['log_date'], 0, 10));
            if (($date_before->diff($date_after))->days === 1) {
                $login_streak_result += 1;
            } else if ($date_before->format('Y-m-d') !== $date_after->format('Y-m-d')) {
                break;
            }
        }

        // 結果を返す
        return $login_streak_result;
    } catch (Exception $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
}
