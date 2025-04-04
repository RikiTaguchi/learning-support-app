<?php // book_id, book_name, limitを指定する
if ($_POST['book_id'] == '1') {
    $book_name = 'パス単(3級)';
    $book_id = 'pass_3';
    $limit = 1200;
}
else if ($_POST['book_id'] == '2') {
    $book_name = 'パス単(準２級)';
    $book_id = 'pass_pre2';
    $limit = 1500;
}
else if ($_POST['book_id'] == '3') {
    $book_name = 'パス単(２級)';
    $book_id = 'pass_2';
    $limit = 1700;
}
else if ($_POST['book_id'] == '4') {
    $book_name = 'パス単(準１級)';
    $book_id = 'pass_pre1';
    $limit = 1900;
}
else if ($_POST['book_id'] == '5') {
    $book_name = 'パス単(１級)';
    $book_id = 'pass_1';
    $limit = 2100;
}
else if ($_POST['book_id'] == '6') {
    $book_name = 'ゲットスルー2600';
    $book_id = 'get_Through_2600';
    $limit = 2100;
}
else if ($_POST['book_id'] == '7') {
    $book_name = '明光暗記テキスト(単語)';
    $book_id = 'meiko_original_1';
    $limit = 453;
}
else if ($_POST['book_id'] == '8') {
    $book_name = '明光暗記テキスト(文法)';
    $book_id = 'meiko_original_2';
    $limit = 100;
}
else if ($_POST['book_id'] == '' || $_POST['book_id'] == 'n') {
    $book_name = 'none';
    $book_id = 'none';
    $limit = 0;
}
else if (isset($login_id)) {
    $book_id = $_POST['book_id'];
    $limit = 0;
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];

        if ($book_id == '') {
            header('Location: error.php?type=12', true, 307);
            exit;
        }

        // book_nameの取得
        $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id AND book_id = :book_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $book_name = $result['book_name'];

        // limitの取得
        $sql = 'SELECT * FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $limit = count($result);

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: error.php?type=2', true, 307);
        exit;
    }
}
