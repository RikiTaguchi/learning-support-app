<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

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
        <title>スタンプ一覧</title>
        <meta name = "description" content = "管理者ログイン">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/info_stamp.css" rel = "stylesheet">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/set-banner.js"></script>
        <script src = "../common/js/set-stamp3.js"></script>
        <script src = "../common/js/check-submit.js"></script>
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
                            echo '<div class = "stamp-block-img"><img src = "' . $img_path . '"></div>';
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
                                                echo '<img src = "' . $img_path . '">';
                                                echo '<p>確率：' . $stamp_data[3] . '</p>';
                                            echo '</div>';
                                        } else {
                                            echo '<div class = "stamp-panel" style = "display: none;">';
                                                echo '<img src = "' . $img_path . '">';
                                                echo '<p>確率：' . $stamp_data[3] . '</p>';
                                            echo '</div>';
                                        }
                                    }
                                echo '</div>';
                                echo '<button class = "stamp-block-right" type = "button">〉</button>';
                            echo '</div>';
                            echo '<div class = "stamp-count">';
                                echo '<div class = "count-block" style = "background-color: lightseagreen;"></div>';
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
                                echo '<img class = "qr-img" src = "' . $qr_path . '">';
                                echo '<div class = "qr-icon"><img src = "' . $img_path . '"></div>';
                            echo '</div>';
                            echo '<a class = "qr-download" href = "' . $qr_path . '" download = "qr_' . $img_list[$i]['table_id'] . $img_list[$i]['img_id'] . '.png">保存</a>';
                            echo '<button class = "qr-close" type = "button">閉じる</button>';
                        echo '</div>';
                    } else if (in_array($img_list[$i]['img_id'], $stamp_random_id) == false) { // ランダム
                        $stamp_random_id[] = $img_list[$i]['img_id'];
                        $qr_path = '../common/qr/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '_qr.png';
                        
                        // QRコード
                        echo '<div class = "qr-block" style = "display: none;">';
                            echo '<div class = "qr-back">';
                                echo '<img class = "qr-img" src = "' . $qr_path . '">';
                                echo '<div class = "qr-icon"><img src = "../common/images/qr-back.png"></div>';
                            echo '</div>';
                            echo '<a class = "qr-download" href = "' . $qr_path . '" download = "qr_' . $img_list[$i]['table_id'] . $img_list[$i]['img_id'] . '.png">保存</a>';
                            echo '<button class = "qr-close" type = "button">閉じる</button>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </main>
    </body>
</html>
