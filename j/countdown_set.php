<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

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
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "カウントダウン更新">
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
                <p class = "main-block-title">カウントダウン</p>
                <form class = "form" method = "post" action = "countdown_edit.php" autocomplete="off">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input class = "info_account" type = "text" name = "edit_mode" value = "edit">';
                    ?>
                    <div class = "form-content-3">
                        <span>タイトル</span>
                        <input type = "text" name = "user_title" value = "<?php echo $user_countdown_title ?>" required>
                    </div>
                    <div class = "form-content-3">
                        <span>日程</span>
                        <input type = "date" name = "user_date" <?php if ($user_countdown_date != 0) { echo 'value = "' . date('Y-m-d', $user_countdown_date) . '"'; } ?> required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit" name = "edit_type" value = "edit">更新</button></div>
                    </div>
                </form>
                <form class = "form form-last" method = "post" action = "countdown_edit.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input class = "info_account" type = "text" name = "edit_mode" value = "reset">';
                    ?>
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit" name = "edit_type" value = "reset">リセット</button></div>
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
