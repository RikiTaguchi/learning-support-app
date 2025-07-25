<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['d'];
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
    $table_id = $result['table_id'];
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "生徒登録">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/make_student.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.2"></script>
        <script src = "../common/js/set-banner.js?v=1.0.4"></script>
        <script src = "../common/js/disable-form.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">生徒登録</p>

                <form class = "form" method = "POST" action = "make_student_check.php" autocomplete="off">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <div class = "form-content-3">
                        <span>氏名</span>
                        <input class = "form-user" type = "text" name = "student_user_name" required>
                    </div>
                    <div class = "form-content-2">
                        <span>区分</span>
                        <div>
                            <p><input type = "radio" name = "student_account_type" value = "e" checked>小学生</p>
                            <p><input type = "radio" name = "student_account_type" value = "j">中学生</p>
                            <p><input type = "radio" name = "student_account_type" value = "h">高校生</p>
                        </div>
                    </div>
                    <div class = "form-content-3">
                        <span>ログインID</span>
                        <input class = "form-login" type = "text" name = "student_login_id" required>
                    </div>
                    <div class = "form-content-3">
                        <span>パスワード</span>
                        <input class = "form-pass" type = "text" name = "student_user_pass" required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit">
                            <button type = "submit" name = "submit">登録</button>
                        </div>
                    </div>
                </form>
                
                <?php make_link2('戻る', 'info_student.php', [$user_name, $login_id, $user_pass]) ?>
            </div>
        </main>
    </body>
</html>
