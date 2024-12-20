<?php
include('./source.php');
include('../info_db.php');

if ($director_id == '' || $director_pass == '' || $director_name == '') {
    header('Location: ../error.php?type=24', true, 307);
    exit;
}

if ($director_id == 'removed' || $director_pass == 'removed' || $director_name == 'removed') {
    header('Location: ../error.php?type=26', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_director WHERE director_id = :director_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':director_id', $director_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 管理者IDの重複チェック
    if ($result['director_id'] != false) {
        $dbh = null;
        header('Location: ../error.php?type=26', true, 307);
        exit;
    }

    $i = 0;
    $sql = 'SELECT table_id FROM info_director';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    while ($i == 0) {
        $table_id = rand(100000, 999999); // table_idの生成
        $check_id = true;
        foreach ($result as $row) {
            if ($table_id == $row['table_id']) {
                $check_id = false;
                break;
            }
        }
        if ($check_id == true) { // 管理者アカウントの追加
            $insert_data = '\'' . $director_id . '\', \'' . $director_name . '\', \'' . $director_pass . '\', \'' . (string)$table_id . '\'';
            $sql = 'INSERT INTO info_director VALUE(' . $insert_data . ')';
            $dbh->query($sql);
            break;
        }
    }
    
    $dbh = null;

    // cookieに管理者情報を保存
    setcookie('director_id', $director_id, time() + (60 * 60 * 24 * 60));
    setcookie('director_pass', $director_pass, time() + (60 * 60 * 24 * 60));

    header('Location: login_director.php?banner=27', true, 307);
    exit;
} catch (PDOException $e) {
    header('Location: ../error.php?type=24', true, 307);
    exit;
}
