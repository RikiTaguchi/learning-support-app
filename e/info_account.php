<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['e', 'j', 'h'];
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
    $login_id = $result['login_id'];
    $user_pass = $result['user_pass'];
    $user_name = $result['user_name'];
    $class_id = (int)$result['class_id'];
    $account_status = $result['account_status'];

    if ($class_id != 0) {
        $sql = 'SELECT * FROM info_account WHERE table_id = :class_table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':class_table_id', $class_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $class_name = $result['user_name'];
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
        <title>スタンプカード</title>
        <meta name = "description" content = "単語システムアカウント情報">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/info_account.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest2.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.2"></script>
        <script src = "../common/js/set-banner.js?v=1.0.4"></script>
        <script src = "../common/js/check-submit.js?v=1.0.3"></script>
        <script src = "../common/js/disable-form.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">アカウント情報</p>
                <form class = "form" method = "post" action = "edit_account.php" autocomplete="off">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "form-content-3">
                        <span>ユーザーネーム</span>
                        <?php if ($class_id == 0) { ?>
                            <input type = "text" name = "new_user_name" value ="<?php echo $user_name ?>" required>
                        <?php } else { ?>
                            <input type = "text" name = "new_user_name" value ="<?php echo $user_name ?>" style = "background-color: #eee; color: #555; pointer-events: none;" readonly required>
                        <?php } ?>
                    </div>
                    <div class = "form-content-3">
                        <span>所属教室</span>
                        <?php if ($class_id == 0) { ?>
                            <input type = "text" name = "class_id" value ="なし" style = "background-color: #eee; color: #555; pointer-events: none;" disabled>
                        <?php } else { ?>
                            <input type = "text" name = "class_id" value ="<?php echo $class_name ?>" style = "background-color: #eee; color: #555; pointer-events: none;" disabled>
                        <?php } ?>
                    </div>
                    <div class = "form-content-2" <?php if ($class_id == 0) { echo 'style = "display: none;"'; } ?>>
                        <span>ステータス</span>
                        <div>
                            <p><input type = "radio" name = "new_account_status" value = "open" <?php if ($account_status == 'open') { echo 'checked'; } ?>>公開</p>
                            <p><input type = "radio" name = "new_account_status" value = "close" <?php if ($account_status == 'close') { echo 'checked'; } ?>>非公開</p>
                        </div>
                    </div>
                    <div class = "form-content-3">
                        <span>ログインID</span>
                        <input type = "text" name = "new_login_id" value ="<?php echo $login_id ?>" required>
                    </div>
                    <div class = "form-content-3">
                        <span>パスワード</span>
                        <input type = "text" name = "new_user_pass" value ="<?php echo $user_pass ?>" required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit">更新</button></div>
                    </div>
                </form>
                <form class = "form form-last" method = "post" action = "delete_account.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "form-content">
                        <div class = "form-content-submit">
                            <?php
                            if ($class_id == 0) {
                                echo '<button type = "submit" onclick="return checkClick()">削除</button>';
                            } else {
                                echo '<button type = "submit" style = "background-color: #ccc; color: #888; border: 1px solid #aaa; opacity: 0.7;" disabled>削除</button>';
                            }
                            ?>
                        </div>
                    </div>
                </form>
                <?php make_link2('ホームに戻る', 'index.php', [$user_name, $login_id, $user_pass]) ?>
            </div>
        </main>
    </body>
</html>
