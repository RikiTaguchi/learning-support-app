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
        <meta name = "description" content = "単語システムログインページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/form.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/login.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/set-cookie.js?v=1.0.1"></script>
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
    </head>
    <body>
        <div class = "main-banner">
            <p class = "main-banner-text"><?php echo $banner_msg; ?></p>
        </div>
        <main class = "main">
            <div class = "login-block">
                <p>高校生版</p>
                <img src = "../common/images/meiko-logo.png">
            </div>
            <div class = "main-block">
                <p class = "main-block-title">ログイン</p>
                <form class = "form" method = "post" action = "login_check.php" autocomplete="off">
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
                            <button type = "submit" name = "submit">ログイン</button>
                        </div>
                    </div>
                </form>
                <p class = "main-block-announce">
                    <a href = "make_account.php">新規登録</a>
                </p>
            </div>

            <div style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
