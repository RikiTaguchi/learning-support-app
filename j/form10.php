<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = 'j';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>計算トレーニング</title>
        <meta name = "description" content = "計算トレーニング">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css" rel = "stylesheet">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/set-banner.js"></script>
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
                        <div class = "form-content-submit"><input type = "submit" value = "開始"></div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
