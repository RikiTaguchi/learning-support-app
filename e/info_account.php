<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');

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
        <title>アカウント情報</title>
        <meta name = "description" content = "単語システムアカウント情報">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css" rel = "stylesheet">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/set-banner.js"></script>
        <script src = "../common/js/check-submit.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">アカウント情報</p>
                <form class = "form" method = "post" action = "edit_account.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "form-content-3">
                        <span>ユーザーネーム</span>
                        <input type = "text" name = "new_user_name" value ="<?php echo $user_name ?>">
                    </div>
                    <div class = "form-content-3">
                        <span>ログインID</span>
                        <input type = "text" name = "new_login_id" value ="<?php echo $login_id ?>">
                    </div>
                    <div class = "form-content-3">
                        <span>パスワード</span>
                        <input type = "text" name = "new_user_pass" value ="<?php echo $user_pass ?>">
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><input type = "submit" value = "更新"></div>
                    </div>
                </form>
                <form class = "form form-last" method = "post" action = "delete_account.php" onSubmit = "return checkSubmit()">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "form-content">
                        <div class = "form-content-submit"><input type = "submit" value = "削除"></div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
