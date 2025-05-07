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
    $img_id = (int)$_POST['img_id'];
    
    $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND img_id = :img_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stamp_title = $result[0]['img_title'];
    $stamp_limit = $result[0]['date_limit'];

    if ($result[0]['stamp_id'] == 'none') {
        $stamp_type = 'normal';
        $stamp_number = 0;
    } else {
        $stamp_type = 'random';
        $stamp_number = count($result);
    }

    $stamp_info = [];
    foreach ($result as $i => $row) {
        $stamp_info[] = [(string)$row['table_id'], (string)$row['img_id'], (string)$row['stamp_id'], (string)$row['stamp_prob'], (string)$row['img_extention']];
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
        <meta name = "description" content = "スタンプ編集">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/form.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/form_stamp.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.0"></script>
        <script src = "../common/js/set-stamp2.js?v=1.0.0"></script>
        <script src = "../common/js/set-banner.js?v=1.0.2"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">スタンプ編集</p>
                <form class = "form" method = "POST" enctype = "multipart/form-data" action = "edit_stamp.php">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name ?>">
                    <input class = "page-count" type = "text" name = "page_count" style = "display: none;" value = "<?php echo $stamp_number ?>">
                    <input type = "text" name = "img_id" value = "<?php echo (string)$img_id; ?>" style = "display: none;">
                    
                    <div class = "form-content">
                        <span>タイトル</span><input type = "text" name = "stamp_title" value = "<?php echo $stamp_title ?>" required>
                    </div>
                    <div class = "form-content">
                        <span>有効期限</span>
                        <input type = "date" name = "date_limit" value = "<?php echo $stamp_limit ?>" required>
                    </div>

                    <!-- スタンプ -->
                    <?php if ($stamp_type == 'normal') { ?>
                        <!-- 通常 -->
                        <div class = "form-normal" style = "display: flex;">
                            <div class = "normal-button">
                                <span>スタンプ</span>
                                <button class = "button-normal" type = "button">
                                    <span>ファイルを選択</span>
                                    <input class = "file-normal" type = "file" name = "img_data" accept = "image/*">
                                </button>
                            </div>
                            <div class = "normal-image">
                                <img class = "preview-normal" src = "<?php echo '../common/stamp/' . $stamp_info[0][0] . '_' . $stamp_info[0][1] . '.' . $stamp_info[0][4] . '?version=' . uniqid(); ?>">
                            </div>
                        </div>
                    <?php } else { ?>
                        <!-- ランダム -->
                        <div class = "form-random" style = "display: flex;">
                            <div class = "random-panel">
                                <div class = "random-panel-back">
                                    <button type = "button">〈</button>
                                </div>
                                <?php if ($stamp_number > 0) { ?>
                                    <div class = "random-area" style = "display: flex">
                                        <div class = "random-button">
                                            <span>スタンプ１</span>
                                            <button class = "button-random" type = "button">
                                                <span>ファイルを選択</span>
                                                <input class = "file-random" type = "file" name = "img_data_1" accept = "image/*">
                                            </button>
                                        </div>
                                        <div class = "random-prob">
                                            <span>確率(%)</span>
                                            <input class = "prob-random" type = "number" name = "prob_1" value = "<?php echo $stamp_info[0][3] ?>" required>
                                        </div>
                                        <div class = "random-image">
                                            <img class = "preview-random" src = "<?php echo '../common/stamp/' . $stamp_info[0][0] . '_' . $stamp_info[0][1] . '_' . $stamp_info[0][2] . '.' . $stamp_info[0][4] . '?version=' . uniqid() ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($stamp_number > 1) { ?>
                                    <div class = "random-area" style = "display: none;">
                                        <div class = "random-button">
                                            <span>スタンプ２</span>
                                            <button class = "button-random" type = "button">
                                                <span>ファイルを選択</span>
                                                <input class = "file-random" type = "file" name = "img_data_2" accept = "image/*">
                                            </button>
                                        </div>
                                        <div class = "random-prob">
                                            <span>確率(%)</span>
                                            <input class = "prob-random" type = "number" name = "prob_2" value = "<?php echo $stamp_info[1][3] ?>" required>
                                        </div>
                                        <div class = "random-image">
                                            <img class = "preview-random" src = "<?php echo '../common/stamp/' . $stamp_info[1][0] . '_' . $stamp_info[1][1] . '_' . $stamp_info[1][2] . '.' . $stamp_info[1][4] . '?version=' . uniqid() ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($stamp_number > 2) { ?>
                                    <div class = "random-area" style = "display: none;">
                                        <div class = "random-button">
                                            <span>スタンプ３</span>
                                            <button class = "button-random" type = "button">
                                                <span>ファイルを選択</span>
                                                <input class = "file-random" type = "file" name = "img_data_3" accept = "image/*">
                                            </button>
                                        </div>
                                        <div class = "random-prob">
                                            <span>確率(%)</span>
                                            <input class = "prob-random" type = "number" name = "prob_3" value = "<?php echo $stamp_info[2][3] ?>" required>
                                        </div>
                                        <div class = "random-image">
                                            <img class = "preview-random" src = "<?php echo '../common/stamp/' . $stamp_info[2][0] . '_' . $stamp_info[2][1] . '_' . $stamp_info[2][2] . '.' . $stamp_info[2][4] . '?version=' . uniqid() ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($stamp_number > 3) { ?>
                                    <div class = "random-area" style = "display: none;">
                                        <div class = "random-button">
                                            <span>スタンプ４</span>
                                            <button class = "button-random" type = "button">
                                                <span>ファイルを選択</span>
                                                <input class = "file-random" type = "file" name = "img_data_4" accept = "image/*">
                                            </button>
                                        </div>
                                        <div class = "random-prob">
                                            <span>確率(%)</span>
                                            <input class = "prob-random" type = "number" name = "prob_4" value = "<?php echo $stamp_info[3][3] ?>" required>
                                        </div>
                                        <div class = "random-image">
                                            <img class = "preview-random" src = "<?php echo '../common/stamp/' . $stamp_info[3][0] . '_' . $stamp_info[3][1] . '_' . $stamp_info[3][2] . '.' . $stamp_info[3][4] . '?version=' . uniqid() ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($stamp_number > 4) { ?>
                                    <div class = "random-area" style = "display: none;">
                                        <div class = "random-button">
                                            <span>スタンプ５</span>
                                            <button class = "button-random" type = "button">
                                                <span>ファイルを選択</span>
                                                <input class = "file-random" type = "file" name = "img_data_5" accept = "image/*">
                                            </button>
                                        </div>
                                        <div class = "random-prob">
                                            <span>確率(%)</span>
                                            <input class = "prob-random" type = "number" name = "prob_5" value = "<?php echo $stamp_info[4][3] ?>" required>
                                        </div>
                                        <div class = "random-image">
                                            <img class = "preview-random" src = "<?php echo '../common/stamp/' . $stamp_info[4][0] . '_' . $stamp_info[4][1] . '_' . $stamp_info[4][2] . '.' . $stamp_info[4][4] . '?version=' . uniqid() ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class = "random-panel-next">
                                    <button type = "button">〉</button>
                                </div>
                            </div>
                            <div class = "random-count">
                                <?php
                                for ($i = 0; $i < $stamp_number; $i++) {
                                    if ($i == 0) {
                                        echo '<div class = "count-block" style = "display: block; background-color: rgb(0, 149, 224);"></div>';
                                    } else {
                                        echo '<div class = "count-block" style = "display: block; background-color: lightgray;"></div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- 送信 -->
                    <div class = "form-content">
                        <div class = "form-content-submit"><button class = "stamp-submit" type = "submit">更新</button></div>
                    </div>
                </form>
            </div>

            <div style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
