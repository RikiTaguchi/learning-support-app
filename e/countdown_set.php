<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
    $user_countdown_title = $result['countdown_title'];
    $user_countdown_date = strtotime($result['countdown_date']);
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>カウントダウン</title>
        <meta name = "description" content = "カウントダウン更新">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css" rel = "stylesheet">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <script src = "../common/js/toggle-menu.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">カウントダウン</p>
                <form class = "form" method = "post" action = "countdown_edit.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">
                    <div class = "form-content-3">
                        <span>タイトル</span>
                        <input type = "text" name = "user_title" value = "<?php echo $user_countdown_title ?>">
                    </div>
                    <div class = "form-content-3">
                        <span>日程</span>
                        <input type = "date" name = "user_date" value = "<?php echo date('Y-m-d', $user_countdown_date) ?>">
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit" name = "edit_type" value = "edit">更新</button></div>
                    </div>
                </form>
                <form class = "form form-last" method = "post" action = "countdown_edit.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">
                    <div class = "form-content">
                        <div class = "form-content-submit"><button type = "submit" name = "edit_type" value = "reset">リセット</button></div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
