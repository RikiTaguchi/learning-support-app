<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('./source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$new_book_name = $_POST['new_book_name'];
$book_id = $_POST['book_id'];
$state = $_POST['state'];
$question = $_POST['question'];
$answer = $_POST['answer'];

if ($state === 'new') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];

        // MyBookリストの取得
        $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 既存の参考書との重複チェック
        $i = 0;
        while ($i == 0) {
            foreach ($result as $row) {
                if ($row == null) {
                    break;
                } else if (($new_book_name == $row['book_name'] && $table_id == $row['table_id']) || in_array($new_book_name, $book_name_list)) {
                    header('Location: form4.php?banner=13', true, 307);
                    exit;
                }
            }
            break;
        }

        // book_idの生成
        $i = 0;
        while ($i == 0) {
            $book_id = rand(100000, 999999);
            $check_id = true;
            foreach ($result as $row) {
                if ((string)$book_id == $row['book_id']) {
                    $check_id = false;
                    break;
                }
            }
            if ($check_id == true) {
                break;
            }
        }

        // MyBookの追加
        $insert_data = $table_id . ', \'' . (string)$book_id . '\', \'' . $new_book_name . '\', \'\'';
        $sql = 'INSERT INTO info_my_book_index (table_id, book_id, book_name, memo) VALUES(:table_id, :book_id, :book_name, \'\')';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':book_name', $new_book_name, PDO::PARAM_STR);
        $stmt->execute();

        $dbh = null;

        // ログを更新
        set_log($login_id, 5, 'set', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
} else {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "My単語帳作成フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.0" rel = "stylesheet">
        <link href = "../common/css/make_my_book.css?v=1.0.0" rel = "stylesheet">
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
                <p class = "main-block-title">My単語帳</p>
                <p class = "mybook-msg">登録完了：<?php echo $new_book_name; ?></p>
                <form class = "form" method = "post" action = "detail.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input class = "info_account" type = "text" name = "book_id" value = "' . $book_id . '">';
                    ?>
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit">詳細</button></div>
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
