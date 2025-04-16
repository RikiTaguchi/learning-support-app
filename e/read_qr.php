<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = 'e';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>スタンプカード</title>
        <meta name = "description" content = "QRコード読取">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/read_qr.css" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <main class = "main">
            <div id = "wrapper">
                <div class = "msg"><p>QRコードを読み取ってください。</p></div>
                <video id = "video" autoplay muted playsinline></video>
                <canvas id = "camera-canvas"></canvas>
                <canvas id = "rect-canvas"></canvas>
                <form class = "main-form-back" method = "post" action = "detail_stamp.php">
                    <?php
                    echo '<input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">';
                    echo '<input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">';
                    echo '<input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">';
                    ?>
                    <button class = "main-form-back-button" type = "submit"><p>閉じる</p></button>
                </form>
            </div>
            <div id = "main-inner-form-area">
                <form class = "main-form-qr" method = "post" action = "">
                    <?php
                    echo '<input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">';
                    echo '<input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">';
                    echo '<input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">';
                    ?>
                    <img class = "main-form-qr-preview" src = "../common/images/non.png">

                    <div class = "main-form-qr-preview-list">
                        <img class = "main-form-qr-preview-0" src = "../common/images/roulette.gif">
                    </div>
                    
                    <button class = "main-form-qr-button" type = "submit" style = "display: none;"><p>このスタンプを取得</p></button>
                    <button class = "main-form-qr-button-back" type = "button" style = "display: none;"><p>戻る</p></button>
                </form>
            </div>
            <script src = "../common/js/jsQR.js"></script>
            <script src = "../common/js/set-qr.js"></script>
        </main>
    </body>
</html>
