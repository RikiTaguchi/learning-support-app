<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['j'];
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
    
    // MyBookリストの取得
    $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 復習リストの取得
    $sql = 'SELECT * FROM info_feedback WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $list_feedback = [];
    foreach ($result2 as $row) {
        if (in_array($row['book_id'], $list_feedback) == false) {
            $list_feedback[] = $row['book_id'];
        }
    }

    if (count($list_feedback) == 0) {
        header('Location: index.php?banner=12', true, 307);
        exit;
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "復習モード入力フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.1" rel = "stylesheet">
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
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
        <script src = "../common/js/disable-form.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">復習モード</p>
                <form  class = "form" method = "post" action = "feedback.php" autocomplete="off">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "form-content">
                        <span>参考書</span>
                        <select class = "form-select" name = "book_id" required id="mySelect">
                            <?php
                            set_options_feedback($list_feedback);
                            foreach ($result as $row) {
                                if (in_array($row['book_id'], $list_feedback)) {
                                    echo '<option value = "' . $row['book_id'] . '">' . $row['book_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class = "form-content-2">
                        <span>出題形式</span>
                        <div>
                            <p><input type = "radio" name = "order" value = "1" checked>ランダム</p>
                            <p><input type = "radio" name = "order" value = "2">番号順</p>
                        </div>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit">開始</button></div>
                    </div>
                </form>
                <?php make_link2('ホームに戻る', 'index.php', [$user_name, $login_id, $user_pass]) ?>
            </div>

            <div style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
