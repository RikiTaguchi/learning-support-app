<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');
include('./source_book.php');

$account_type = 'd';
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
    $user_countdown_title = $result['countdown_title'];
    $user_countdown_date = strtotime($result['countdown_date']);
    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}

// お知らせの取得
try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_notice WHERE account_type = :account_type';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':account_type', $account_type, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;
    foreach ($result as $row) {
        $notice[] = $row;
    }
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
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
    header('Location: error.php?type=2', true, 307);
    exit;
}

include('../common/banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "単語システムトップページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/index.css" rel = "stylesheet">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/set-banner.js"></script>
        <script src = "../common/js/check-submit.js"></script>
		<script>
            const button = new Array(<?php echo (string)count($notice); ?>);
            const detail = new Array(<?php echo (string)count($notice); ?>);

			<?php foreach ($notice as $i => $info) { ?>
				window.addEventListener('load', () => {
                    button[<?php echo (string)$i; ?>] = document.querySelector(<?php echo '\'.main-notice-button-' . (string)$info['id'] . '\''; ?>);
                    detail[<?php echo (string)$i; ?>] = document.querySelector(<?php echo '\'.main-notice-detail-' . (string)$info['id'] . '\''; ?>);
                    detail[<?php echo (string)$i; ?>].style.display = 'none';

                    const options = {
                        duration: 250,
                        easing: 'ease',
                        fill: 'forwards',
                    };

                    const openDetail = {
                        opacity: [0, 1],
                    };

                    button[<?php echo (string)$i; ?>].addEventListener('click', () => {
                        if (detail[<?php echo (string)$i; ?>].style.display === 'none') {
                            detail[<?php echo (string)$i; ?>].style.display = 'block';
                            detail[<?php echo (string)$i; ?>].animate(openDetail, options);
                        } else {
                            detail[<?php echo (string)$i; ?>].style.display = 'none';
                        }
                    });
                });
			<?php } ?>
		</script>
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
                    <form method = "post" action = "countdown_set.php">
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
                    echo '<div class = "main-notice-list">';
                        for ($i = count($notice) - 1; $i >= 0; $i -= 1) {
                            echo '<div class = "main-notice-list-block">';
                                echo '<div class = "main-notice-list-subblock">';
                                    echo '<p class = "main-notice-subtitle">' . $notice[$i]['title'] . '</p>';
                                    echo '<p class = "main-notice-date">' . $notice[$i]['date'] . '</p>';
                                    echo '<button class = "main-notice-button-root main-notice-button-' . (string)$notice[$i]['id'] . '"><p>詳細</p></button>';
                                echo '</div>';
                                echo '<div class = "main-notice-detail-root main-notice-detail-' . (string)$notice[$i]['id'] . '"><p>' . $notice[$i]['detail'] . '</p></div>';
                            echo '</div>';
                            echo '<hr class = "main-notice-line">';
                        }
                    echo '</div>';
                }
                ?>
            </div>

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
                                <form method = "post" action = "detail.php">
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
                        echo '<form method = "post" action = "form4.php">';
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
