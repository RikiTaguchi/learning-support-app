<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('./source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    
    $sql = 'SELECT * FROM info_account WHERE class_id = :class_id AND account_type = \'e\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_STR);
    $stmt->execute();
    $result_e = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM info_account WHERE class_id = :class_id AND account_type = \'j\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_STR);
    $stmt->execute();
    $result_j = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM info_account WHERE class_id = :class_id AND account_type = \'h\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_STR);
    $stmt->execute();
    $result_h = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}

$grade_list = [
    'h' => '高校生',
    'j' => '中学生',
    'e' => '小学生'
]
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "生徒管理">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.1" rel = "stylesheet">
        <link href = "../common/css/info_student.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.1"></script>
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
        <script src = "../common/js/check-submit.js?v=1.0.1"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">生徒管理</p>

                <form class = "form-add" method = "POST" action = "make_student.php">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <button type = "submit">生徒を追加</button>
                </form>

                <table class = "info-table">
                    <tr>
                        <th class = "th-name">氏名</th>
                        <th class = "th-grade">区分</th>
                        <th class = "th-edit"></th>
                        <th class = "th-delete"></th>
                        <th class = "th-print"></th>
                    </tr>
                    <?php
                    foreach ($result_e as $row) {
                        $form_edit = '
                            <form class = "form-edit" method = "POST" action = "edit_student.php">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">更新</button>
                            </form>
                        ';
                        $form_delete = '
                            <form class = "form-delete" method = "POST" action = "delete_student.php" onSubmit = "return checkSubmit4();">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">削除</button>
                            </form>
                        ';
                        echo '<tr>';
                            echo '<td class = "td-name">' . $row['user_name'] . '</td>';
                            echo '<td class = "td-grade">' . $grade_list[$row['account_type']] . '</td>';
                            echo '<td class = "td-edit">' . $form_edit . '</td>';
                            echo '<td class = "td-delete">' . $form_delete . '</td>';
                            echo '<td class = "td-print"><button type = "button">配布資料を印刷</button></td>';
                        echo '</tr>';
                    }
                    foreach ($result_j as $row) {
                        $form_edit = '
                            <form class = "form-edit" method = "POST" action = "edit_student.php">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">更新</button>
                            </form>
                        ';
                        $form_delete = '
                            <form class = "form-delete" method = "POST" action = "delete_student.php" onSubmit = "return checkSubmit4();">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">削除</button>
                            </form>
                        ';
                        echo '<tr>';
                            echo '<td class = "td-name">' . $row['user_name'] . '</td>';
                            echo '<td class = "td-grade">' . $grade_list[$row['account_type']] . '</td>';
                            echo '<td class = "td-edit">' . $form_edit . '</td>';
                            echo '<td class = "td-delete">' . $form_delete . '</td>';
                            echo '<td class = "td-print"><button type = "button">配布資料を印刷</button></td>';
                        echo '</tr>';
                    }
                    foreach ($result_h as $row) {
                        $form_edit = '
                            <form class = "form-edit" method = "POST" action = "edit_student.php">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">更新</button>
                            </form>
                        ';
                        $form_delete = '
                            <form class = "form-delete" method = "POST" action = "delete_student.php" onSubmit = "return checkSubmit4();">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">削除</button>
                            </form>
                        ';
                        echo '<tr>';
                            echo '<td class = "td-name">' . $row['user_name'] . '</td>';
                            echo '<td class = "td-grade">' . $grade_list[$row['account_type']] . '</td>';
                            echo '<td class = "td-edit">' . $form_edit . '</td>';
                            echo '<td class = "td-delete">' . $form_delete . '</td>';
                            echo '<td class = "td-print"><button type = "button">配布資料を印刷</button></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>

                <?php make_link2('ホームに戻る', 'index.php', [$user_name, $login_id, $user_pass]) ?>
            </div>

            <div style="margin-top: 20px;">
                <!-- for SP -->
                <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
            </div>
        </main>
    </body>
</html>
