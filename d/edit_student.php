<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('./source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

// 生徒のテーブルIDを取得
$student_table_id = $_POST['student_table_id'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 管理者のテーブルIDを取得
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    // 生徒情報を取得
    $sql = 'SELECT * FROM info_account WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $student_user_name = $result['user_name'];
    $student_login_id = $result['login_id'];
    $student_user_pass = $result['user_pass'];
    $student_account_type = $result['account_type'];

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
        <meta name = "description" content = "生徒情報更新">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/edit_student.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.1"></script>
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">生徒情報更新</p>

                <form class = "form" method = "POST" action = "edit_student_check.php" autocomplete="off">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <input type = "number" name = "student_table_id" style = "display: none;" value = "<?php echo $student_table_id; ?>">
                    <div class = "form-content-3">
                        <span>氏名</span>
                        <input class = "form-user" type = "text" name = "student_user_name" value = "<?php echo $student_user_name ?>" required>
                    </div>
                    <div class = "form-content-2">
                        <span>区分</span>
                        <div>
                            <p><input type = "radio" name = "student_account_type" value = "e" <?php if ($student_account_type == 'e') { echo 'checked'; } ?>>小学生</p>
                            <p><input type = "radio" name = "student_account_type" value = "j" <?php if ($student_account_type == 'j') { echo 'checked'; } ?>>中学生</p>
                            <p><input type = "radio" name = "student_account_type" value = "h" <?php if ($student_account_type == 'h') { echo 'checked'; } ?>>高校生</p>
                        </div>
                    </div>
                    <div class = "form-content-3">
                        <span>ログインID</span>
                        <input class = "form-login" type = "text" name = "student_login_id" value = "<?php echo $student_login_id ?>" required>
                    </div>
                    <div class = "form-content-3">
                        <span>パスワード</span>
                        <input class = "form-pass" type = "text" name = "student_user_pass" value = "<?php echo $student_user_pass ?>" required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit">
                            <button type = "submit" name = "submit">更新</button>
                        </div>
                    </div>
                </form>
                
                <?php make_link2('戻る', 'info_student.php', [$user_name, $login_id, $user_pass]) ?>
            </div>

            <div style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
