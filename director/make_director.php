<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>管理者アカウント作成</title>
        <meta name = "description" content = "管理者アカウント作成">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/make_account.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/set-banner2.js"></script>

    </head>
    <body>
        <header class = "header">
            <div class = "header-inner">
                <a class = "header-logo" href = "./login_director.php">
                    <img src = "../images/logo-1.png" alt = "ロゴ画像">
                </a>
            </div>
            <div class = "main-banner"><p class = "main-banner-text"></p></div>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <p class = "main-title">アカウント情報</p>
                <form method = "post" action = "make_director_check.php">
                    <p>管理者名</p>
                    <input class = "main-form-input" type = "text" name = "director_name" required>
                    <p>管理者ID</p>
                    <input class = "main-form-input" type = "text" name = "director_id" required>
                    <p>パスワード</p>
                    <input class = "main-form-input" type = "text" name = "director_pass" required>
                    <div class = "main-form-make"><input class = "main-make-button" type = "submit" name = "submit" value = "登録"></div>
                </form>
                <p class = "main-back">
                    <a href = "login_director.php">ログイン画面へ戻る</a>
                </p>
            </div>
        </main>
        <footer class = "footer">
            <div class = "footer-inner">
                <div class = "footer-logo">
                    <a href = "./login_director.php">
                        <img src = "../images/logo-3.png" alt = "ロゴ画像">
                    </a>
                </div>
                <div class = "footer-site-menu">
                    <ul>
                        <p class = "footer-copyright">&copy;Wordsystem</p>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>
