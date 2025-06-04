<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

// ログの集計
try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $user_account_type = $result['account_type'];

    // ログの集計結果を格納する配列
    $info_report = [];
    
    // ログイン
    $sql = 'SELECT * FROM info_analysis WHERE table_id = :table_id AND log_code = 0 AND log_detail = \'login\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $info_report[] = count($result); // 総ログイン回数
    $info_report[] = $login_streak; // 連続ログイン日数
    if (count($result) != 0) {
        $info_report[] = substr($result[count($result) - 1]['log_date'], 0, 10); // 最終ログイン日
    } else {
        $info_report[] = '-'; // 未ログイン（エラー）
    }

    // テスト作成
    $sql = 'SELECT * FROM info_analysis WHERE table_id = :table_id AND log_code = 1';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $info_report[] = count($result); // 使用回数

    // スタンプ登録
    $sql = 'SELECT * FROM info_analysis WHERE table_id = :table_id AND log_code = 7 AND log_detail = \'set\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $info_report[] = count($result); // 使用回数

    // 管轄生徒数
    $sql = 'SELECT * FROM info_account WHERE class_id = :class_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $info_report[] = count($result); // 使用回数

    // 総スタンプ取得数
    $students = $result;
    $stamp_get_count = 0;
    for ($i = 0; $i < count($students); $i++) {
        $student_table_id = $students[$i]['table_id'];
        $sql = 'SELECT * FROM info_stamp WHERE user_table_id = :user_table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_table_id', $student_table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stamp_get_count += count($result);
    }
    $info_report[] = $stamp_get_count;

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
        <meta name = "description" content = "使用レポート">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/report.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.3" rel = "stylesheet">
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
                <p class = "main-block-title">使用レポート</p>

                <p class = "report-title">ログイン情報</p>
                <table class = "report-table">
                    <tr><th>総ログイン回数</th><td><?php echo $info_report[0]; ?></td></tr>
                    <tr><th>連続ログイン日数</th><td><?php echo $info_report[1]; ?></td></tr>
                    <tr><th>最終ログイン</th><td><?php echo $info_report[2]; ?></td></tr>
                </table>

                <p class = "report-title">機能使用回数</p>
                <table class = "report-table">
                    <tr><th>テスト作成</th><td><?php echo $info_report[3]; ?></td></tr>
                    <tr><th>スタンプ登録</th><td><?php echo $info_report[4]; ?></td></tr>
                </table>

                <p class = "report-title">教室情報</p>
                <table class = "report-table">
                    <tr><th>管轄生徒数</th><td><?php echo $info_report[5]; ?></td></tr>
                    <tr><th>総スタンプ取得数</th><td><?php echo $info_report[6]; ?></td></tr>
                </table>

                <?php make_link2('ホームに戻る', 'index.php', [$user_name, $login_id, $user_pass]) ?>
            </div>
        </main>
    </body>
</html>
