<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$date_today = strtotime(date('Y-m-d'));
$notice = [];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_name = $result['user_name'];
    $table_id = $result['table_id'];
    $class_id = $table_id;
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

// カウントダウン情報の取得
try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_countdown WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_countdown_title = $result['title'];
    $user_countdown_date = strtotime($result['date_limit']);
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

// お知らせの取得
try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_notice WHERE account_type = :account_type';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':account_type', $account_type[0], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;
    foreach ($result as $row) {
        $notice[] = $row;
    }
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // MyBookリストの取得
    $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $my_book_is_exist = false;
    foreach ($result as $row) {
        $book_count_list[] = 0;
        $book_id_list[] = $row['book_id'];
        $book_name_list[] = $row['book_name'];
        $my_book_is_exist = true;
    }
    
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

// スタンプ取得数ランキングの作成
try {
    if ($class_id != '0') {
        // データを格納する配列
        $stamp_info = [];
        $stamp_ranking = [];

        // DB接続
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 管理者名の取得
        $sql = 'SELECT * FROM info_account WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $class_name = $result['user_name'];

        // 生徒情報の取得
        $sql = 'SELECT * FROM info_account WHERE class_id = :class_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // スタンプ取得情報の取得
        for ($i = 0; $i < count($result); $i++) {
            $sql = 'SELECT * FROM info_stamp WHERE user_table_id = :user_table_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':user_table_id', $result[$i]['table_id'], PDO::PARAM_INT);
            $stmt->execute();
            $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stamp_info[] = [$result[$i]['table_id'], $result[$i]['user_name'], count($r)];
        }

        // ランキングの算出
        for ($i = 0; $i < count($stamp_info) - 1; $i++) {
            for ($j = 0; $j < count($stamp_info) - 1 - $i; $j++) {
                if ($stamp_info[$j][2] < $stamp_info[$j + 1][2]) {
                    $temp = $stamp_info[$j + 1];
                    $stamp_info[$j + 1] = $stamp_info[$j];
                    $stamp_info[$j] = $temp;
                }
            }
        }

        // ランキング１〜５位を格納
        $rank_data = $stamp_info[0][2];
        $rank_count = 1;
        if ($rank_data > 0) {
            for ($i = 0; $i < count($stamp_info) - 1; $i++) {
                if ($stamp_info[$i][2] == $rank_data) {
                    $stamp_ranking[] = [$rank_count, $stamp_info[$i][1], $stamp_info[$i][2]];
                } else if ($rank_count < 5) {
                    if ($stamp_info[$i][2] > 0) {
                        $rank_count += 1;
                        $stamp_ranking[] = [$rank_count, $stamp_info[$i][1], $stamp_info[$i][2]];
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
        }

        // DBとの接続を解除
        $dbh = null;
    }
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
        <meta name = "description" content = "単語システムトップページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/index.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.2" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.1"></script>
        <script src = "../common/js/toggle-notice.js?v=1.0.1"></script>
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
        <script src = "../common/js/check-submit.js?v=1.0.3"></script>
        <script src = "../common/js/disable-form.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <?php
                if ($user_countdown_title != '' && $user_countdown_date != strtotime('0000-00-00') && ($user_countdown_date - $date_today) / (60 * 60 * 24) >= 0) {
                    echo '<div class = "countdown-block1">';
                        echo '<p class = "countdown-text1">' . $user_countdown_title . '</p>';
                        echo '<p class = "countdown-text2">まで</p>';
                    echo '</div>';
                    echo '<div class = "countdown-block2">';
                        echo '<p class = "countdown-text3">あと</p>';
                        echo '<p class = "countdown-text4">' . ($user_countdown_date - $date_today) / (60 * 60 * 24) . '</p>';
                        echo '<p class = "countdown-text5">日！</p>';
                    echo '</div>';
                } else {
                    echo '<p class = "main-block-title">カウントダウン</p>';
                    echo '<p class = "main-block-announce">日程が登録されていません。</p>';
                }
                ?>
                <div class = "main-block-button">
                    <form class = "form2" method = "post" action = "countdown_set.php">
                        <div>
                            <?php
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            ?>
                        </div>
                        <div>
                            <button type = "submit">
                                <?php
                                if ($user_countdown_title != '' && $user_countdown_date != strtotime('0000-00-00') && ($user_countdown_date - $date_today) / (60 * 60 * 24) >= 0) {
                                    echo '<p>編集</p>';
                                } else {
                                    echo '<p>登録</p>';
                                }
                                ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class = "main-block">
                <p class = "main-block-title">お知らせ</p>
                <?php
                if ((count($notice) - 1) < 0) {
                    echo '<p class = "main-block-announce">現在お知らせはありません。</p>';
                } else {
                    echo '<div class = "notice-list">';
                        for ($i = count($notice) - 1; $i >= 0; $i -= 1) {
                            echo '<div class = "notice-list-block">';
                                echo '<div class = "notice-list-subblock">';
                                    echo '<p class = "notice-subtitle">' . $notice[$i]['title'] . '</p>';
                                    echo '<p class = "notice-date">' . $notice[$i]['date'] . '</p>';
                                    echo '<button class = "notice-button"><p>詳細</p></button>';
                                echo '</div>';
                                echo '<div class = "notice-detail" style = "display: none;"><p>' . $notice[$i]['detail'] . '</p></div>';
                            echo '</div>';
                            echo '<hr class = "notice-line">';
                        }
                    echo '</div>';
                }
                ?>
            </div>

            <?php if ($class_id != '0' && count($stamp_ranking) > 0) { ?>
            <div class = "main-block">
                <p class = "main-block-title">ランキング</p>
                <p class = "ranking-title">スタンプ取得数</p>
                <?php
                echo '<table class = "ranking-table">';
                for ($i = 0; $i < count($stamp_ranking); $i++) {
                    echo '<tr><td>' . $stamp_ranking[$i][0] . '位</td><th>' . $stamp_ranking[$i][1] . '</th><td>' . $stamp_ranking[$i][2] . '個</td></tr>';
                }
                echo '</table>';
                ?>
                <p class = "ranking-class-name">対象：<?php echo $class_name; ?></p>
            </div>
            <?php } ?>

            <div class = "main-block">
                <p class = "main-block-title">My単語帳</p>
                <?php
                if ($my_book_is_exist == true) {
                    echo '<table class = "mybook-table">';
                        for ($i = $default_count; $i < count($book_id_list); $i += 1) {
                            echo '<tr>';
                            echo '<th>' . $book_name_list[$i] . '</th>';
                            $text_form = '
                                <td>
                                <form class = "form2" method = "post" action = "detail.php">
                                    <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                    <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                    <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                    <input class = "info_account" type = "text" name = "book_name" value = "' . $book_name_list[$i] . '">
                                    <input class = "info_account" type = "text" name = "book_id" value = "' . $book_id_list[$i] . '">
                                    <button type = "submit">
                                        <p>編集</p>
                                    </button>
                                </form>
                                </td>
                            ';
                            echo $text_form;
                            echo '</tr>';
                        }
                    echo '</table>';
                } else {
                    echo '<p class = "main-block-announce">My単語帳が登録されていません。</p>';
                    echo '<div class = "main-block-button">';
                        echo '<form class = "form2" method = "post" action = "form4.php">';
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            echo '<button type = "submit">';
                                echo '<p>登録</p>';
                            echo '</button>';
                        echo '</form>';
                    echo '</div>';
                }
                ?>
                </div>
            </div>
        </main>
    </body>
</html>
