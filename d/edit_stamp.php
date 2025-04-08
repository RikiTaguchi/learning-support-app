<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');
include('../common/banner.php');

$img_title_new = $_POST['stamp_title'];
$date_limit_new = $_POST['date_limit'];
$stamp_number = (int)$_POST['page_count'];

if ($stamp_number === 0) {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];
        $img_id = (int)$_POST['img_id'];
        
        $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND img_id = :img_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $img_extention_delete = $result['img_extention'];

        if (isset($_FILES['img_data']) && $_FILES['img_data']['error'] === UPLOAD_ERR_NO_FILE) {
            $sql = 'UPDATE info_image SET img_title = :img_title, date_limit = :date_limit WHERE table_id = :table_id AND img_id = :img_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':img_title', $img_title_new, PDO::PARAM_STR);
            $stmt->bindParam(':date_limit', $date_limit_new, PDO::PARAM_STR);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
        } else {
            $img_extention = explode('.', $_FILES['img_data']['name'])[1];
            $file_path = '../common/stamp/' . (string)$table_id . '_' . (string)$img_id . '.' . $img_extention;
            $file_path_delete = '../common/stamp/' . (string)$table_id . '_' . (string)$img_id . '.' . $img_extention_delete;
            unlink($file_path_delete);
            move_uploaded_file($_FILES['img_data']['tmp_name'], $file_path);
            $sql = 'UPDATE info_image SET img_extention = :img_extention, img_title = :img_title, date_limit = :date_limit WHERE table_id = :table_id AND img_id = :img_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':img_extention', $img_extention, PDO::PARAM_STR);
            $stmt->bindParam(':img_title', $img_title_new, PDO::PARAM_STR);
            $stmt->bindParam(':date_limit', $date_limit_new, PDO::PARAM_STR);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
        }
        $stmt->execute();
        $dbh = null;

        header('Location: info_stamp.php', true, 307);
        exit;
    } catch (PDOException $e) {
        header('Location: login.php', true, 307);
        exit;
    }
} else {
    for ($i = 0; $i < $stamp_number; $i++) {
        try {
            $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $table_id = $result['table_id'];
            $img_id = (int)$_POST['img_id'];
            $stamp_prob = $_POST['prob_' . (string)($i + 1)];
            
            $stamp_id = (string)$i;
            $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND img_id = :img_id AND stamp_id = :stamp_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
            $stmt->bindParam(':stamp_id', $stamp_id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $img_extention_delete = $result['img_extention'];
            
            $stamp_id = (string)$i;
            if (isset($_FILES['img_data_' . (string)($i + 1)]) && $_FILES['img_data_' . (string)($i + 1)]['error'] === UPLOAD_ERR_NO_FILE) {
                $sql = 'UPDATE info_image SET img_title = :img_title, date_limit = :date_limit, stamp_prob = :stamp_prob WHERE table_id = :table_id AND img_id = :img_id AND stamp_id = :stamp_id';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':img_title', $img_title_new, PDO::PARAM_STR);
                $stmt->bindParam(':date_limit', $date_limit_new, PDO::PARAM_STR);
                $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
                $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
                $stmt->bindParam(':stamp_id', $stamp_id, PDO::PARAM_STR);
                $stmt->bindParam(':stamp_prob', $stamp_prob, PDO::PARAM_STR);
            } else {
                $img_extention = explode('.', $_FILES['img_data_' . (string)($i + 1)]['name'])[1];
                $file_path = '../common/stamp/' . (string)$table_id . '_' . (string)$img_id . '_' . (string)$i . '.' . $img_extention;
                $file_path_delete = '../common/stamp/' . (string)$table_id . '_' . (string)$img_id . '_' . (string)$i . '.' . $img_extention_delete;
                unlink($file_path_delete);
                move_uploaded_file($_FILES['img_data_' . (string)($i + 1)]['tmp_name'], $file_path);
                $sql = 'UPDATE info_image SET img_extention = :img_extention, img_title = :img_title, date_limit = :date_limit, stamp_prob = :stamp_prob WHERE table_id = :table_id AND img_id = :img_id AND stamp_id = :stamp_id';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':img_extention', $img_extention, PDO::PARAM_STR);
                $stmt->bindParam(':img_title', $img_title_new, PDO::PARAM_STR);
                $stmt->bindParam(':date_limit', $date_limit_new, PDO::PARAM_STR);
                $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
                $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
                $stmt->bindParam(':stamp_id', $stamp_id, PDO::PARAM_STR);
                $stmt->bindParam(':stamp_prob', $stamp_prob, PDO::PARAM_STR);
            }
            $stmt->execute();
            $dbh = null;
        } catch (PDOException $e) {
            header('Location: login.php', true, 307);
            exit;
        }
    }

    header('Location: info_stamp.php', true, 307);
    exit;
}
