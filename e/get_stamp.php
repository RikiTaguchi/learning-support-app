<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

if ($login_id == '' || $user_pass == '') {
    header('Location: login.php?banner=17', true, 307);
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
    $user_table_id = $result['table_id'];
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

$director_table_id = $_GET['table_id'];
$img_id = $_GET['img_id'];
$img_extention_list = [];
$img_probability_list = [];

$stamp_count_limit = 3;

if ($_GET['img_extention_0'] != '') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND img_id = :img_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $director_table_id, PDO::PARAM_INT);
        $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $img_extention_list[] = $row['img_extention'];
        }
        $dbh = null;
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (count($img_extention_list) == 0) {
        $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND img_id = :img_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $director_table_id, PDO::PARAM_INT);
        $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $img_extention = $result['img_extention'];
        $img_title = $result['img_title'];
        $stamp_id = 'none';
        date_default_timezone_set('Asia/Tokyo');
        $date_limit = strtotime($result['date_limit']);
        $date_today = strtotime(date('Y-m-d'));
    } else {
        foreach ($img_extention_list as $i => $data_extention) {
            $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND img_id = :img_id AND stamp_id = :stamp_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':table_id', $director_table_id, PDO::PARAM_INT);
            $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
            $stmt->bindParam(':stamp_id', $i, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $img_probability_list[] = (int)$result['stamp_prob'];
            date_default_timezone_set('Asia/Tokyo');
            $date_limit = strtotime($result['date_limit']);
            $date_today = strtotime(date('Y-m-d'));
        }
        $result_number = rand(1, 100);
        $border_prob = 0;
        foreach ($img_extention_list as $i => $data_extention) {
            $border_prob += (int)$img_probability_list[$i];
            if ($result_number <= $border_prob) {
                $stamp_id = (string)$i;
                break;
            }
        }
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

if (($date_limit - $date_today) / (60 * 60 * 24) >= 0) {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_stamp';
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $i = 1;
        foreach ($result as $row) {
            $i += 1;
        }

        if ($i > $stamp_count_limit) {
            header('Location: detail_stamp.php?banner=23', true, 307);
            exit;
        }

        $get_date_set = date('Y-m-d');
        $sql = 'INSERT INTO info_stamp (id, user_table_id, director_table_id, img_id, stamp_id, get_date) VALUES(:id, :user_table_id, :director_table_id, :img_id, :stamp_id, :get_date)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $i, PDO::PARAM_INT);
        $stmt->bindParam(':user_table_id', $user_table_id, PDO::PARAM_INT);
        $stmt->bindParam(':director_table_id', $director_table_id, PDO::PARAM_INT);
        $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
        $stmt->bindParam(':stamp_id', $stamp_id, PDO::PARAM_STR);
        $stmt->bindParam(':get_date', $get_date_set, PDO::PARAM_STR);
        $stmt->execute();

        $dbh = null;

        header('Location: detail_stamp.php?banner=15', true, 307);
        exit;
    } catch (PDOException $e) {
        header('Location: login.php?banner=9', true, 307);
        exit;
    }
} else {
    header('Location: detail_stamp.php?banner=16', true, 307);
    exit;
}
