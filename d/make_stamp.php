<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

// QRコード生成に必要な機能
include('../common/domain_info.php');
include('../common/phpqrcode/qrlib.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

// 基本情報の取得
$img_title = $_POST['stamp_title'];
$date_limit = $_POST['date_limit'];

// 有効期限が過去の日付の場合
$date_target = DateTime::createFromFormat('Y-m-d', $date_limit);
$date_today = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$date_target->setTime(0, 0, 0);
$date_today->setTime(0, 0, 0);
if ($date_target < $date_today) {
    header('Location: form7.php?banner=24', true, 307);
    exit;
}

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
        $img_info = 'table_id=' . (string)$table_id . '&img_id=' . (string)$img_id . '&img_extention=' . $img_extention;
        $get_stamp_url = $domain . '/e/get_stamp.php?' . $img_info;
        $qr_name = (string)$table_id . '_' . (string)$img_id . '_qr.png';
        $qr_path = '../common/qr/' . $qr_name;
        QRcode::png($get_stamp_url, $qr_path, QR_ECLEVEL_H);
    
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

        // ログを更新
        set_log($login_id, 7, 'set', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

        // リダイレクト（スタンプ一覧）
        header('Location: info_stamp.php?banner=6', true, 307);
        exit;
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

        // QRコードの生成とアップロード
        $img_info = 'table_id=' . (string)$table_id . '&img_id=' . (string)$img_id . '&img_extention_0=' . $img_extention[0];
        $get_stamp_url = $domain . '/e/get_stamp.php?' . $img_info;
        $qr_name = (string)$table_id . '_' . (string)$img_id . '_qr.png';
        $qr_path = '../common/qr/' . $qr_name;
        QRcode::png($get_stamp_url, $qr_path, QR_ECLEVEL_H);
    
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
        
        $dbh = null;

        // ログを更新
        set_log($login_id, 7, 'set', date('Y-m-d H:i:s'), $db_host, $db_name, $db_user, $db_pass);

        // リダイレクト（スタンプ一覧）
        header('Location: info_stamp.php?banner=6', true, 307);
        exit;
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
}
