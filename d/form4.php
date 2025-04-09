<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

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
        <title>My単語帳作成</title>
        <meta name = "description" content = "My単語帳作成フォーム">
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
                <p class = "main-block-title">My単語帳</p>
                <form  class = "form" method = "post" action = "make_my_book.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <input class = "info_account" type = "text" name = "state" value = "new">
                    <div class = "form-content">
                        <span>単語帳名</span>
                        <input type = "text" name = "new_book_name" required>
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><input type = "submit" value = "作成"></div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
