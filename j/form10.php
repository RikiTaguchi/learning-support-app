<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['j'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "計算トレーニング">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.0"></script>
        <script src = "../common/js/set-banner.js?v=1.0.1"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">計算トレーニング</p>
                <form class = "form" method = "post" action = "math_question.php">
                    <input type = "number" name = "question_count" value = 1 style = "display: none;">
                    <input type = "number" name = "question_correct" value = 0 style = "display: none;">
                    <input type = "text" name = "login_id" value = "<?php echo $login_id; ?>" style = "display: none;">
                    <input type = "text" name = "user_pass" value = "<?php echo $user_pass; ?>" style = "display: none;">
                    <input type = "text" name = "user_name" value = "<?php echo $user_name; ?>" style = "display: none;">
                    <input type = "text" name = "param_feedback" value = "" style = "display: none;">
                    <input type = "text" name = "passed_time_h" value = "00" style = "display: none;">
                    <input type = "text" name = "passed_time_m" value = "00" style = "display: none;">
                    <input type = "text" name = "passed_time_s" value = "00" style = "display: none;">
                    <div class = "form-content">
                        <span>単元</span>
                        <select class = "form-select" name = "type" required>
                            <option value = "n" hidden>選択してください</option>
                            <option value = "1">正負の数(中1)</option>
                            <option value = "2">１次方程式(中1)</option>
                            <option value = "3">連立方程式(中2)</option>
                            <option value = "4">展開(中3)</option>
                            <option value = "5">因数分解(中3)</option>
                            <option value = "6">平方根(中3)</option>
                        </select>
                    </div>
                    <div class = "form-content">
                        <span>レベル</span>
                        <select class = "form-select" name = "level" required>
                            <option value = "n" hidden>選択してください</option>
                            <option value = "1">★</option>
                            <option value = "2">★★</option>
                            <option value = "3">★★★</option>
                            <option value = "4">★★★★</option>
                            <option value = "5">★★★★★</option>
                        </select>
                    </div>
                    <div class = "form-content">
                        <span>出題数</span><input type = "number" name = "question_number" required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit">開始</button></div>
                    </div>
                </form>
            </div>

            <div style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
