<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('./source_book.php');

$account_type = 'h';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

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
    
    // 復習リストの取得
    $sql = 'SELECT * FROM info_feedback WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $list_feedback = [];
    foreach ($result2 as $row) {
        if (in_array($row['book_id'], $list_feedback) == false) {
            $list_feedback[] = $row['book_id'];
        }
    }

    if (count($list_feedback) == 0) {
        header('Location: index.php?banner=12', true, 307);
        exit;
    }

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
        <title>復習モード</title>
        <meta name = "description" content = "復習モード入力フォーム">
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
                <p class = "main-block-title">復習モード</p>
                <form  class = "form" method = "post" action = "feedback.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "form-content">
                        <span>参考書</span>
                        <select class = "form-select" name = "book_id" required id="mySelect">
                            <?php
                            set_options_feedback($list_feedback);
                            foreach ($result as $row) {
                                if (in_array($row['book_id'], $list_feedback)) {
                                    echo '<option value = "' . $row['book_id'] . '">' . $row['book_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class = "form-content-2">
                        <span>出題形式</span>
                        <div>
                            <p><input type = "radio" name = "order" value = "1" checked>ランダム</p>
                            <p><input type = "radio" name = "order" value = "2">番号順</p>
                        </div>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><input type = "submit" value = "開始"></div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
