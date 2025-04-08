<?php
include('./source.php');
include('../info_db.php');

$img_title = $_POST['img_title'];
$date_limit = $_POST['date_limit'];

$stamp_count = 0;
$stamp_number = [];
$img_extention = [];
$img_probability = [];
for ($i = 0; $i < 5; $i += 1) {
    if (is_uploaded_file($_FILES['img_data_' . (string)$i]['tmp_name'])) {
        $stamp_count += 1;
        $stamp_number[] = $i;
        $img_extention[] = explode('.', $_FILES['img_data_' . (string)$i]['name'])[1];
        $img_probability[] = $_POST['prob_data_' . (string)$i];
    }
}

if ($stamp_count == 0 || count($stamp_number) != count($img_extention)) {
    header('Location: error.php?type=24', true, 307);
    exit;
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
        $file_path = './images_stamp/' . $file_name;
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
    header('Location: error.php?type=24', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>スタンプ登録</title>
        <meta name = "description" content = "スタンプ登録">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <link href = "./css/make_stamp.css" rel = "stylesheet">
    </head>
    <body>
        <header class = "header">
            <?php include('./header2.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <h1>登録完了</h1>
                <div class = "main-inner-img-block">
                    <img class = "main-inner-img-qr" src = "<?php echo $qr_url; ?>">
                    <div class = "main-inner-img-back"><img class = "main-inner-img-back-inner" src = "./images/qr-back.png"></div>
                </div>
                <form class = "main-inner-form" method = "POST" action = "detail_stamp.php">
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
                    <button type = "submit">スタンプ一覧へ</button>
                </form>
            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer2.php'); ?>
        </footer>
    </body>
</html>
