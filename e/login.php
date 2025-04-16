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
        <title>スタンプカード</title>
        <meta name = "description" content = "単語システムログインページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/form.css" rel = "stylesheet">
        <link href = "../common/css/login.css" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest2.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/set-cookie.js"></script>
        <script src = "../common/js/set-banner.js"></script>
    </head>
    <body>
        <div class = "main-banner">
            <p class = "main-banner-text"><?php echo $banner_msg; ?></p>
        </div>
        <main class = "main">
            <div class = "login-block">
                <p>明光義塾</p>
                <img src = "../common/images/stamp-logo.png">
            </div>
            <div class = "main-block">
                <p class = "main-block-title">ログイン</p>
                <form class = "form" method = "post" action = "login_check.php">
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
        </main>
    </body>
</html>
