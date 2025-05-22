<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 管理者テーブルIDの取得
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    
    // 小学生アカウントの取得
    $sql = 'SELECT * FROM info_account WHERE class_id = :class_id AND account_type = \'e\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_STR);
    $stmt->execute();
    $result_e = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 中学生アカウントの取得
    $sql = 'SELECT * FROM info_account WHERE class_id = :class_id AND account_type = \'j\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_STR);
    $stmt->execute();
    $result_j = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 高校生アカウントの取得
    $sql = 'SELECT * FROM info_account WHERE class_id = :class_id AND account_type = \'h\'';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':class_id', $table_id, PDO::PARAM_STR);
    $stmt->execute();
    $result_h = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 生徒アカウント情報の結合
    $result = [];
    foreach ($result_e as $row) {
        $result[] = $row;
    }
    foreach ($result_j as $row) {
        $result[] = $row;
    }
    foreach ($result_h as $row) {
        $result[] = $row;
    }

    // レポート情報の取得
    $info_student_list = [];
    foreach ($result as $row) {
        // 格納配列（２次元）
        $info_student = [];

        // ログイン履歴（info_analysis）
        $sql = 'SELECT * FROM info_analysis WHERE table_id = :table_id AND log_code = 0 AND log_detail = \'login\' ORDER BY log_date ASC';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $row['table_id'], PDO::PARAM_STR);
        $stmt->execute();
        $r_login = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // スタンプ取得履歴（info_stamp）
        $sql = 'SELECT * FROM info_stamp WHERE user_table_id = :user_table_id ORDER BY get_date ASC';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_table_id', $row['table_id'], PDO::PARAM_STR);
        $stmt->execute();
        $r_stamp_1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // スタンプ取得履歴（info_analysis）
        $sql = 'SELECT * FROM info_analysis WHERE table_id = :table_id AND log_code = 7 AND log_detail = \'get\' ORDER BY log_date ASC';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $row['table_id'], PDO::PARAM_STR);
        $stmt->execute();
        $r_stamp_2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // データ抽出（最終ログイン日時）
        if (empty($r_login)) {
            if (empty($r_stamp_1)) {
                $info_student[] = '未ログイン';
            } else {
                $info_student[] = $r_stamp_1[count($r_stamp_1) - 1]['get_date'];
            }
        } else {
            $info_student[] = $r_login[count($r_login) - 1]['log_date'];
        }

        // データ抽出（総ログイン）
        $info_student[] = (string)count($r_login);

        // データ抽出（月ログイン）
        $info_student[] = '準備中';

        // データ抽出（週ログイン）
        $info_student[] = '準備中';

        // データ抽出（連続ログイン）
        $info_student[] = '準備中';

        // データ抽出（取得スタンプ数）
        $info_student[] = (string)count($r_stamp_1);

        // データ抽出（最終スタンプ取得日時）
        if (empty($r_stamp_2)) {
            if (empty($r_stamp_1)) {
                $info_student[] = '未取得';
            } else {
                $info_student[] = $r_stamp_1[count($r_stamp_1) - 1]['get_date'];
            }
        } else {
            $info_student[] = $r_stamp_2[count($r_stamp_2) - 1]['log_date'];
        }

        // 結果を格納
        $info_student_list[] = $info_student;
    }

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
        <link href = "../common/css/body.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/info_student.css?v=1.0.3" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.1"></script>
        <script src = "../common/js/set-banner.js?v=1.0.3"></script>
        <script src = "../common/js/check-submit.js?v=1.0.3"></script>
        <script src = "../common/js/set-student.js?v=1.0.0"></script>
        <script src = "../common/js/disable-form.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">生徒管理</p>

                <form class = "form-add form2" method = "POST" action = "make_student.php">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <button type = "submit">生徒を追加</button>
                </form>

                <table class = "info-table">
                    <?php
                    foreach ($result as $i => $row) {
                        // ボタン（form）
                        $form_edit = '
                            <form class = "form2" method = "POST" action = "edit_student.php">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">アカウント情報を更新</button>
                            </form>
                        ';
                        $form_delete = '
                            <form method = "POST" action = "delete_student.php" onSubmit = "return checkSubmit4();">
                                <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $row['table_id'] . '">
                                <button type = "submit">管理対象から外す</button>
                            </form>
                        ';

                        // メイン
                        echo '<tr class = "tr-main">';
                            echo '<td class = "td-name">' . $row['user_name'] . '</td>';
                            echo '<td class = "td-detail"><button class = "detail-button" type = "button">詳細</button></td>';
                        echo '</tr>';

                        // 詳細
                        echo '<tr class = "info-detail" style = "display: none;"><td colspan="2"><table class = "sub-table">';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">区分</td>';
                                echo '<td class = "td-sub-data">' . $grade_list[$row['account_type']] . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">最終ログイン</td>';
                                echo '<td class = "td-sub-data">' . $info_student_list[$i][0] . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">総ログイン</td>';
                                echo '<td class = "td-sub-data">' . $info_student_list[$i][1] . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">月ログイン</td>';
                                echo '<td class = "td-sub-data">' . $info_student_list[$i][2] . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">週ログイン</td>';
                                echo '<td class = "td-sub-data">' . $info_student_list[$i][3] . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">連続ログイン</td>';
                                echo '<td class = "td-sub-data">' . $info_student_list[$i][4] . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">取得スタンプ</td>';
                                echo '<td class = "td-sub-data">' . $info_student_list[$i][5] . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-sub">';
                                echo '<td class = "td-sub-title">最終スタンプ取得</td>';
                                echo '<td class = "td-sub-data">' . $info_student_list[$i][6] . '</td>';
                            echo '</tr>';
                        echo '</table></td></tr>';

                        // ボタン
                        echo '<tr class = "info-button" style = "display: none;"><td colspan="2"><table class = "button-table">';
                            echo '<tr class = "tr-button">';
                                echo '<td class = "td-button"><button class = "print-button" type = "button">配布用資料を印刷</button></td>';
                            echo '</tr>';
                            echo '<tr class = "tr-button">';
                                echo '<td class = "td-button">' . $form_edit . '</td>';
                            echo '</tr>';
                            echo '<tr class = "tr-button">';
                                echo '<td class = "td-button">' . $form_delete . '</td>';
                            echo '</tr>';
                        echo '</table></td></tr>';
                    }
                    ?>
                </table>

                <?php make_link2('ホームに戻る', 'index.php', [$user_name, $login_id, $user_pass]) ?>
            </div>
        </main>
    </body>
</html>
