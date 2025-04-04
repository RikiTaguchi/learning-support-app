<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');
include('./source_book.php');

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
    
    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}

include('../common/banner.php');
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>トレーニング</title>
        <meta name = "description" content = "トレーニング入力フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css" rel = "stylesheet">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/toggle-index.js"></script>
        <script src = "../common/js/toggle-index-change.js"></script>
        <script src = "../common/js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <di class = "main-block">
                <p class = "main-block-title">暗記トレーニング</p>
                <?php include('./index_menu.php'); ?>
                <form  class = "form" method = "post" action = "training.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "form-content">
                        <span>参考書</span>
                        <select class = "form-select" name = "book_id" required id="mySelect">
                            <?php
                            echo set_options();
                            foreach ($result as $row) {
                                echo '<option value = "' . $row['book_id'] . '">' . $row['book_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class = "form-content">
                        <span>開始番号</span><input type = "number" name = "start" required>
                    </div>
                    <div class = "form-content">
                        <span>終了番号</span><input type = "number" name = "end" required>
                    </div>
                    <div class = "form-content-2">
                        <span>出題形式</span>
                        <div>
                            <p><input type = "radio" name = "order" value = "1" checked>ランダム</p>
                            <p><input type = "radio" name = "order" value = "2">番号順</p>
                        </div>
                    </div>
                    <div class = "form-content">
                        <span>出題数</span><input type = "number" name = "questions_num" required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><input type = "submit" value = "開始"></div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
