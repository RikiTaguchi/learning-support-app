<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "単語システムアカウント作成ページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/form.css" rel = "stylesheet">
        <link href = "../common/css/make_account.css" rel = "stylesheet">
        <script src = "../common/js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <div class = "header-inner">
                <a class = "header-logo" href = "./login.php">
                    <img src = "../common/images/meiko-logo.png" alt = "ロゴ画像">
                    <p>スタンプカード</p>
                </a>
            </div>
            <div class = "main-banner">
                <p class = "main-banner-text"><?php echo $banner_msg; ?></p>
            </div>
        </header>
        <main class = "main">
            <div class = "main-block">
                <div class = "login-block">
                    <img src = "../common/images/meiko-logo.png">
                    <p>スタンプカード</p>
                </div>
                <form class = "form" method = "post" action = "make_account_check.php">
                    <div class = "form-content-3">
                        <span>ユーザーネーム</span>
                        <input class = "form-user" type = "text" name = "user_name" required>
                    </div>
                    <div class = "form-content-3">
                        <span>ログインID</span>
                        <input class = "form-login" type = "text" name = "login_id" required>
                    </div>
                    <div class = "form-content-3">
                        <span>パスワード</span>
                        <input class = "form-pass" type = "text" name = "user_pass" required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit">
                            <input type = "submit" name = "submit" value = "登録">
                        </div>
                    </div>
                </form>
                <p class = "main-block-announce">
                    <a href = "login.php">ログイン画面へ</a>
                </p>
            </div>
        </main>
    </body>
</html>
