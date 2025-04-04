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
        <script src = "../common/js/set-banner3.js"></script>
    </head>
    <body>
        <header class = "header">
            <div class = "header-inner">
                <a class = "header-logo" href = "./login.php">
                    <img src = "../common/images/logo-1.png" alt = "ロゴ画像">
                </a>
            </div>
            <div class = "main-banner"><p class = "main-banner-text"></p></div>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">新規登録</p>
                <form class = "form" method = "post" action = "make_account_check.php">
                    <input class = "info-banner" type = "text" name = "info_banner" value = "new-account" style = "display: none;">
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
                    <a href = "login.php">ログイン画面へ戻る</a>
                </p>
            </div>
        </main>
    </body>
</html>
