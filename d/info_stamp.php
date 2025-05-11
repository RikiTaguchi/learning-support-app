<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND stamp_state = \'valid\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $img_list = $result;

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
        <meta name = "description" content = "管理者ログイン">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/info_stamp.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/info_stamp_print.css?v=1.0.1" rel = "stylesheet" media = "print">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.1"></script>
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
        <script src = "../common/js/set-stamp3.js?v=1.0.1"></script>
        <script src = "../common/js/print-stamp.js?v=1.0.2"></script>
        <script src = "../common/js/check-submit.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">スタンプ一覧</p>
                <?php
                $stamp_random_id = [];
                $stamp_random_info = [];
                for ($i = 0; $i < count($img_list); $i++) {
                    if ($img_list[$i]['stamp_id'] == 'none' && $img_list[$i]['stamp_prob'] == 'none') { // 通常
                        // タイトル
                        echo '<div class = "stamp-row">';
                            echo '<p class = "stamp-title">' . $img_list[$i]['img_title'] . '</p>';
                            echo '<button class = "stamp-button-detail" type = "button">詳細</button>';
                        echo '</div>';

                        // 詳細
                        echo '<div class = "stamp-block" style = "display: none;">';
                            echo '<p class = "stamp-block-limit">有効期限：' . $img_list[$i]['date_limit'] . '</p>';
                            $img_path = '../common/stamp/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '.' . $img_list[$i]['img_extention'] . '?version=' . uniqid();
                            echo '<div class = "stamp-block-img"><img data-src = "' . $img_path . '"></div>';
                            echo '<button class = "stamp-button-qr" type = "button">QRコード</button>';
                            echo '<form class = "stamp-block-form" method = "post" action = "form8.php">';
                                echo '<input type = "text" name = "img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "login_id" value = "' . $login_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_pass" value = "' . $user_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_name" value = "' . $user_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-edit" type = "submit">編集</button>';
                            echo '</form>';
                            echo '<form class = "stamp-block-form" method = "post" action = "delete_stamp.php" onSubmit = "return checkSubmit3();">';
                                echo '<input type = "text" name = "img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "login_id" value = "' . $login_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_pass" value = "' . $user_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_name" value = "' . $user_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-delete" type = "submit">削除</button>';
                            echo '</form>';
                        echo '</div>';
                        echo '<hr class = "stamp-line">';
                    } else if (in_array($img_list[$i]['img_id'], $stamp_random_id) == false) { // ランダム
                        // スタンプ情報の取得
                        $set_img_id = $img_list[$i]['img_id'];
                        $stamp_random_id[] = $set_img_id;
                        for ($j = $i; $j < count($img_list); $j += 1) {
                            if ($set_img_id == $img_list[$j]['img_id']) {
                                $stamp_random_info[] = [$img_list[$j]['table_id'], $img_list[$j]['img_id'], $img_list[$j]['stamp_id'], $img_list[$j]['stamp_prob'], $img_list[$j]['img_extention'], $img_list[$j]['img_title'], $img_list[$j]['date_limit']];
                            }
                        }

                        // タイトル
                        echo '<div class = "stamp-row">';
                            echo '<p class = "stamp-title">' . $img_list[$i]['img_title'] . '</p>';
                            echo '<button class = "stamp-button-detail" type = "button">詳細</button>';
                        echo '</div>';

                        // 詳細
                        echo '<div class = "stamp-block" style = "display: none;">';
                            echo '<p class = "stamp-block-limit">有効期限：' . $img_list[$i]['date_limit'] . '</p>';
                            echo '<div class = "stamp-block-img">';
                                echo '<button class = "stamp-block-left" type = "button">〈</button>';
                                echo '<div>';
                                    foreach ($stamp_random_info as $j => $stamp_data) {
                                        $img_path = '../common/stamp/' . $stamp_data[0] . '_' . $stamp_data[1] . '_' . $stamp_data[2] . '.' . $stamp_data[4] . '?version=' . uniqid();
                                        if ($j === 0) {
                                            echo '<div class = "stamp-panel" style = "display: flex;">';
                                                echo '<img data-src = "' . $img_path . '">';
                                                echo '<p>確率：' . $stamp_data[3] . '%</p>';
                                            echo '</div>';
                                        } else {
                                            echo '<div class = "stamp-panel" style = "display: none;">';
                                                echo '<img data-src = "' . $img_path . '">';
                                                echo '<p>確率：' . $stamp_data[3] . '%</p>';
                                            echo '</div>';
                                        }
                                    }
                                echo '</div>';
                                echo '<button class = "stamp-block-right" type = "button">〉</button>';
                            echo '</div>';
                            echo '<div class = "stamp-count">';
                                echo '<div class = "count-block" style = "background-color: rgb(0, 149, 224);"></div>';
                                for ($j = 1; $j < count($stamp_random_info); $j++) {
                                    echo '<div class = "count-block" style = "background-color: lightgray;"></div>';
                                }
                            echo '</div>';
                            echo '<button class = "stamp-button-qr" type = "button">QRコード</button>';
                            echo '<form class = "stamp-block-form" method = "post" action = "form8.php">';
                                echo '<input type = "text" name = "img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "login_id" value = "' . $login_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_pass" value = "' . $user_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_name" value = "' . $user_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-edit" type = "submit">編集</button>';
                            echo '</form>';
                            echo '<form class = "stamp-block-form" method = "post" action = "delete_stamp.php" onSubmit = "return checkSubmit3();">';
                                echo '<input type = "text" name = "img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "login_id" value = "' . $login_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_pass" value = "' . $user_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "user_name" value = "' . $user_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-delete" type = "submit">削除</button>';
                            echo '</form>';
                        echo '</div>';
                        echo '<hr class = "stamp-line">';
                        $stamp_random_info = [];
                    }
                }
                $stamp_random_id = [];
                for ($i = 0; $i < count($img_list); $i += 1) {
                    if ($img_list[$i]['stamp_id'] == 'none' && $img_list[$i]['stamp_prob'] == 'none') { // 通常
                        $qr_path = '../common/qr/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '_qr.png';

                        // QRコード
                        echo '<div class = "qr-block" style = "display: none;">';
                            $img_path = "../common/stamp/" . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '.' . $img_list[$i]['img_extention'] . '?version=' . uniqid();
                            echo '<div class = "qr-back">';
                                echo '<img class = "qr-img" data-src = "' . $qr_path . '">';
                                echo '<div class = "qr-icon"><img data-src = "' . $img_path . '"></div>';
                            echo '</div>';
                            echo '<button class = "qr-print" type = "button">印刷</button>';
                            echo '<a class = "qr-download" href = "' . $qr_path . '" download = "qr_' . $img_list[$i]['table_id'] . $img_list[$i]['img_id'] . '.png">保存</a>';
                            echo '<button class = "qr-close" type = "button">閉じる</button>';
                        echo '</div>';
                    } else if (in_array($img_list[$i]['img_id'], $stamp_random_id) == false) { // ランダム
                        $stamp_random_id[] = $img_list[$i]['img_id'];
                        $qr_path = '../common/qr/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '_qr.png';
                        
                        // QRコード
                        echo '<div class = "qr-block" style = "display: none;">';
                            echo '<div class = "qr-back">';
                                echo '<img class = "qr-img" data-src = "' . $qr_path . '">';
                                echo '<div class = "qr-icon"><img data-src = "../common/images/qr-back.png"></div>';
                            echo '</div>';
                            echo '<button class = "qr-print" type = "button">印刷</button>';
                            echo '<a class = "qr-download" href = "' . $qr_path . '" download = "qr_' . $img_list[$i]['table_id'] . $img_list[$i]['img_id'] . '.png">保存</a>';
                            echo '<button class = "qr-close" type = "button">閉じる</button>';
                        echo '</div>';
                    }
                }
                ?>
                <?php make_link2('ホームに戻る', 'index.php', [$user_name, $login_id, $user_pass]) ?>
            </div>
            <div class = "print-block">
                <?php
                $stamp_random_id = [];
                for ($i = 0; $i < count($img_list); $i += 1) {
                    if ($img_list[$i]['stamp_id'] == 'none' && $img_list[$i]['stamp_prob'] == 'none') { // 通常
                        $qr_path = '../common/qr/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '_qr.png';

                        // 印刷ページ
                        echo '<div class = "print-area">';
                            echo '<img class = "print-logo" data-src = "../common/images/stamp-logo.png">';
                            echo '<p class = "print-title">' . $img_list[$i]['img_title'] . '</p>';
                            echo '<p class = "print-limit">有効期限：' . $img_list[$i]['date_limit'] . '</p>';
                            $img_path = "../common/stamp/" . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '.' . $img_list[$i]['img_extention'] . '?version=' . uniqid();
                            echo '<div class = "print-back">';
                                echo '<img class = "print-img" data-src = "' . $qr_path . '">';
                                echo '<div class = "print-icon"><img data-src = "' . $img_path . '"></div>';
                            echo '</div>';
                        echo '</div>';
                    } else if (in_array($img_list[$i]['img_id'], $stamp_random_id) == false) { // ランダム
                        $stamp_random_id[] = $img_list[$i]['img_id'];
                        $qr_path = '../common/qr/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '_qr.png';
                        
                        // 印刷ページ
                        echo '<div class = "print-area">';
                            echo '<img class = "print-logo" data-src = "../common/images/stamp-logo.png">';
                            echo '<p class = "print-title">' . $img_list[$i]['img_title'] . '</p>';
                            echo '<p class = "print-limit">有効期限：' . $img_list[$i]['date_limit'] . '</p>';
                            echo '<div class = "print-back">';
                                echo '<img class = "print-img" data-src = "' . $qr_path . '">';
                                echo '<div class = "print-icon"><img data-src = "../common/images/qr-back.png"></div>';
                            echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <div class = "ads-area" style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
