<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

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
    $student_account_status = $result['account_status'];

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
        <meta name = "description" content = "成績情報登録">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/edit_student.css?v=1.0.0" rel = "stylesheet">
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
                <p class = "main-block-title"><?php echo $student_user_name; ?></p>

                <form class = "form" method = "POST" action = "score_add_check.php" autocomplete="off">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <input type = "number" name = "student_table_id" style = "display: none;" value = "<?php echo $student_table_id; ?>">
                    
                    <div class = "form-content-3">
                        <span>学年</span><br>
                        <select class = "form-grade" name = "score_grade" required>
                            <option value = "n" hidden>選択してください</option>
                            <option value = "0">小学1年</option>
                            <option value = "1">小学2年</option>
                            <option value = "2">小学3年</option>
                            <option value = "3">小学4年</option>
                            <option value = "4">小学5年</option>
                            <option value = "5">小学6年</option>
                            <option value = "6">中学1年</option>
                            <option value = "7">中学2年</option>
                            <option value = "8">中学3年</option>
                            <option value = "9">高校1年</option>
                            <option value = "10">高校2年</option>
                            <option value = "11">高校3年</option>
                            <option value = "12">その他</option>
                        </select>
                    </div>
                    <div class = "form-content-3">
                        <span>種別</span><br>
                        <select class = "form-term" name = "score_term" required>
                            <option value = "n" hidden>選択してください</option>
                            <option value = "0">前期中間</option>
                            <option value = "1">前期期末</option>
                            <option value = "2">後期中間</option>
                            <option value = "3">後期期末(学年末)</option>
                            <option value = "4">1学期中間</option>
                            <option value = "5">1学期期末</option>
                            <option value = "6">2学期中間</option>
                            <option value = "7">2学期期末</option>
                            <option value = "8">3学期期末(学年末)</option>
                            <option value = "9">その他</option>
                        </select>
                    </div>
                    <div class = "form-content-3">
                        <span>科目</span><br>
                        <select class = "form-subject" name = "score_subject" required>
                            <option value = "n" hidden>選択してください</option>
                            <option value = "0">国語(小学生)</option>
                            <option value = "1">算数(小学生)</option>
                            <option value = "2">英語(小学生)</option>
                            <option value = "3">理科(小学生)</option>
                            <option value = "4">社会(小学生)</option>
                            <option value = "5">国語(中学生)</option>
                            <option value = "6">数学(中学生)</option>
                            <option value = "7">英語(中学生)</option>
                            <option value = "8">理科(中学生)</option>
                            <option value = "9">社会(中学生)</option>
                            <option value = "10">音楽(中学生)</option>
                            <option value = "11">美術(中学生)</option>
                            <option value = "12">技術家庭(中学生)</option>
                            <option value = "13">保健体育(中学生)</option>
                            <option value = "14">その他</option>
                        </select>
                    </div>
                    
                    <div class = "form-content-3">
                        <span>得点</span>
                        <input class = "form-point" type = "number" name = "score_point" required>
                    </div>
                    <div class = "form-content-3">
                        <span>平均点</span>
                        <input class = "form-average" type = "number" name = "score_average">
                    </div>
                    <div class = "form-content-3">
                        <span>偏差値</span>
                        <input class = "form-deviation" type = "number" name = "score_deviation">
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit">
                            <button type = "submit" name = "submit">登録</button>
                        </div>
                    </div>
                </form>
                
                <?php make_link3('戻る', 'score_info.php', [$user_name, $login_id, $user_pass, $student_table_id]) ?>
            </div>
        </main>
    </body>
</html>
