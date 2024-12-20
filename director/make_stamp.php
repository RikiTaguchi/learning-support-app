<?php
include('./source.php');
include('../info_db.php');

$img_title = $_POST['img_title'];
$date_limit = $_POST['date_limit'];
$img_extention = explode('.', $_FILES['img_data']['name'])[1];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_director WHERE director_id = :director_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':director_id', $director_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    if ($director_pass != $result['director_pass']) {
        $dbh = null;
        header('Location: ../error.php?type=24', true, 307);
        exit;
    }

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
    $file_path = './images_stamp/' . $file_name;
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
    header('Location: ../error.php?type=24', true, 307);
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
                    <div class = "main-inner-img-back"><img class = "main-inner-img-back-inner" src = "<?php echo $file_path; ?>"></div>
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
