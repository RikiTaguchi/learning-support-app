<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

// 基本情報の取得
$img_title = $_POST['stamp_title'];
$date_limit = $_POST['date_limit'];

// タイプの判定・画像の登録
$page_count = (int)$_POST['page_count'];
if ($page_count == 0) {
    // 通常
    $img_extention = explode('.', $_FILES['img_data']['name'])[1];
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];
    
        // img_idの生成
        $sql = 'SELECT * FROM info_image WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        while (true) {
            $check = false;
            $img_id = rand(100000, 999999);
            foreach ($result as $row) {
                if ($img_id == $row['img_id']) {
                    $check = true;
                    break;
                }
            }
            if ($check == false) {
                break;
            }
        }
    
        // スタンプ画像のアップロード
        $file_name = (string)$table_id . '_' . (string)$img_id . '.' . $img_extention;
        $file_path = '../common/stamp/' . $file_name;
        $result = move_uploaded_file($_FILES['img_data']['tmp_name'], $file_path);
    
        // QRコードの生成とアップロード
        $qr_url = './make_qr.php?table_id=' . (string)$table_id . '&img_id=' . (string)$img_id . '&img_extention=' . $img_extention;
    
        // スタンプ情報の登録
        $sql = 'INSERT INTO info_image VALUE(:table_id, :img_id, \'none\', \'none\', :img_extention, :img_title, :date_limit, \'valid\')';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
        $stmt->bindParam(':img_extention', $img_extention, PDO::PARAM_STR);
        $stmt->bindParam(':img_title', $img_title, PDO::PARAM_STR);
        $stmt->bindParam(':date_limit', $date_limit, PDO::PARAM_STR);
        $stmt->execute();
    
        $dbh = null;
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
} else {
    // ランダム
    $stamp_count = $page_count;
    $stamp_number = [];
    $img_extention = [];
    $img_probability = [];
    for ($i = 0; $i < $stamp_count; $i += 1) {
        if (is_uploaded_file($_FILES['img_data_' . (string)($i + 1)]['tmp_name'])) {
            $stamp_number[] = $i + 1;
            $img_extention[] = explode('.', $_FILES['img_data_' . (string)($i + 1)]['name'])[1];
            $img_probability[] = $_POST['prob_' . (string)($i + 1)];
        }
    }
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];
    
        // img_idの生成
        $sql = 'SELECT * FROM info_image WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $img_id = 0;
        while (true) {
            $check = false;
            $img_id = rand(100000, 999999);
            foreach ($result as $row) {
                if ($img_id == $row['img_id']) {
                    $check = true;
                    break;
                }
            }
            if ($check == false) {
                break;
            }
        }
    
        for ($i = 0; $i < $stamp_count; $i += 1) {
            // スタンプ画像のアップロード
            $file_name = (string)$table_id . '_' . (string)$img_id . '_' . (string)$i . '.' . $img_extention[$i];
            $file_path = '../common/stamp/' . $file_name;
            $result = move_uploaded_file($_FILES['img_data_' . (string)$stamp_number[$i]]['tmp_name'], $file_path);
    
            // スタンプ情報の登録
            $stamp_id = (string)$i;
            $stamp_prob = (string)$img_probability[$i];
            $sql = 'INSERT INTO info_image VALUE(:table_id, :img_id, :stamp_id, :stamp_prob, :img_extention, :img_title, :date_limit, \'valid\')';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
            $stmt->bindParam(':stamp_id', $stamp_id, PDO::PARAM_STR);
            $stmt->bindParam(':stamp_prob', $stamp_prob, PDO::PARAM_STR);
            $stmt->bindParam(':img_extention', $img_extention[$i], PDO::PARAM_STR);
            $stmt->bindParam(':img_title', $img_title, PDO::PARAM_STR);
            $stmt->bindParam(':date_limit', $date_limit, PDO::PARAM_STR);
            $stmt->execute();
        }
        
        // QRコードの生成とアップロード
        $qr_url = './make_qr2.php?table_id=' . (string)$table_id . '&img_id=' . (string)$img_id . '&img_extention_0=' . $img_extention[0];
    
        $dbh = null;
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "スタンプ登録">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/make_stamp.css" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">登録完了</p>
                <div class = "stamp-block">
                    <img class = "stamp-qr" src = "<?php echo $qr_url; ?>">
                    <?php
                    if ($page_count == 0) {
                        echo '<div class = "stamp-icon"><img src = "' . $file_path . '"></div>';
                    } else {
                        echo '<div class = "stamp-icon"><img src = "../common/images/qr-back.png"></div>';
                    }
                    ?>
                </div>
                <form class = "stamp-form" method = "POST" action = "info_stamp.php">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <button type = "submit">スタンプ一覧へ</button>
                </form>
            </div>
        </main>
    </body>
</html>
