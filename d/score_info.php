<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/source_book.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

// 生徒のテーブルIDを取得
$student_table_id = $_POST['student_table_id'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 管理者のテーブルIDを取得
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    // 生徒情報を取得
    $sql = 'SELECT * FROM info_account WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $student_user_name = $result['user_name'];
    $student_login_id = $result['login_id'];
    $student_user_pass = $result['user_pass'];
    $student_account_type = $result['account_type'];
    $student_account_status = $result['account_status'];

    // 成績リストの取得
    // table_id, 学年(0~9), 種別①(0~9), 種別②(string), 科目①(0~14), 科目②(string), 得点（float:0.0~）, 平均点（float:0.0~）, 偏差値（float:0.0~）
    // 学年：小学校1年、小学校2年、小学校3年、小学校4年、小学校5年、小学校6年、中学校1年、中学校2年、中学校3年、その他
    // 種別①：前期中間、前期期末、後期中間、後期期末、1学期中間、1学期期末、2学期中間、2学期期末、3学期期末（学年末）、その他
    // 科目①：国語（小学生）、算数（小学生）、英語（小学生）、理科（小学生）、社会（小学生）、国語（中学生）、数学（中学生）、英語（中学生）、理科（中学生）、社会（中学生）、音楽（中学生）、美術（中学生）、技術家庭（中学生）、保健体育（中学生）、その他
    $sql = 'SELECT * FROM info_score WHERE table_id = :table_id ORDER BY grade ASC, term ASC, subject ASC';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $score_list = [
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
        [[[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []], [[], [], [], [], [], [], [], [], [], [], [], [], [], [], []]],
    ];
    $grade_list = ['小学1年', '小学2年', '小学3年', '小学4年', '小学5年', '小学6年', '中学1年', '中学2年', '中学3年', '高校1年', '高校2年', '高校3年', 'その他'];
    $term_list = ['前期中間', '前期期末', '後期中間', '学年末', '1学期中間', '1学期期末', '2学期中間', '2学期期末', '学年末', 'その他'];
    $subject_list = ['国語', '算数', '英語', '理科', '社会', '国語', '数学', '英語', '理科', '社会', '音楽', '美術', '技術家庭', '保健体育', 'その他'];
    $grade_skip_list = [];
    $term_skip_list = [];

    // 成績リストの整形
    for ($i = 0; $i < count($result); $i++) {
        $grade_index = (int)$result[$i]['grade'];
        $term_index = (int)$result[$i]['term'];
        $subject_index = (int)$result[$i]['subject'];
        $score_list[$grade_index][$term_index][$subject_index] = $result[$i];
    }

    // スキップリストの作成（学年）
    function isArrayAllEmpty($array) {
        foreach ($array as $value) {
            if (is_array($value)) {
                if (!isArrayAllEmpty($value)) {
                    return false;
                }
            } elseif (!empty($value)) {
                return false;
            }
        }
        return true;
    }
    for ($i = 0; $i < count($score_list); $i++) {
        if (isArrayAllEmpty($score_list[$i])) {
            $grade_skip_list[] = $i;
        }
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "成績確認">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/info_student.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/score_info.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.2"></script>
        <script src = "../common/js/set-banner.js?v=1.0.4"></script>
        <script src = "../common/js/check-submit.js?v=1.0.4"></script>
        <script src = "../common/js/set-score.js?v=1.0.0"></script>
        <script src = "../common/js/disable-form.js?v=1.0.0"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title"><?php echo $student_user_name; ?></p>

                <form class = "form-add form2" method = "POST" action = "score_add.php">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <input type = "number" name = "student_table_id" style = "display: none;" value = "<?php echo $student_table_id; ?>">
                    <button type = "submit">新規登録</button>
                </form>

                <table class = "info-table">
                    <?php
                    // 学年ごとにスコアを出力
                    for ($i = 0; $i < count($score_list); $i++) {
                        if (!in_array($i, $grade_skip_list)) {
                            // メイン
                            echo '<tr class = "tr-main">';
                                echo '<td class = "td-name">' . $grade_list[$i] . '</td>';
                                echo '<td class = "td-detail"><button class = "detail-button" type = "button">詳細</button></td>';
                            echo '</tr>';

                            // スキップリストの作成（ターム）
                            $term_skip_list = [];
                            for ($l = 0; $l < count($score_list[$i]); $l++) {
                                if (isArrayAllEmpty($score_list[$i][$l])) {
                                    $term_skip_list[] = $l;
                                }
                            }

                            // タームごとにスコアを出力
                            echo '<tr class = "info-detail" style = "display: none;"><td colspan="2"><table class = "sub-table">';
                            for ($j = 0; $j < count($score_list[$i]); $j++) {
                                if (!in_array($j, $term_skip_list)) {
                                    echo '<tr class = "tr-sub">';
                                        echo '<th class = "td-sub-score" colspan="2" style = "text-align: left;">' . $term_list[$j] . '</th>';
                                        echo '<th class = "td-sub-score"></th>';
                                        echo '<th class = "td-sub-score"></th>';
                                        echo '<th class = "td-sub-score"></th>';
                                        echo '<th class = "td-sub-score"></th>';
                                        echo '<th class = "td-sub-score"></th>';
                                    echo '</tr>';

                                    echo '<tr class = "tr-sub">';
                                        echo '<th class = "td-sub-score">科目</th>';
                                        echo '<th class = "td-sub-score">得点</th>';
                                        echo '<th class = "td-sub-score">平均</th>';
                                        echo '<th class = "td-sub-score">偏差値</th>';
                                        echo '<th class = "td-sub-score"></th>';
                                        echo '<th class = "td-sub-score"></th>';
                                    echo '</tr>';
                                    
                                    // 科目ごとにスコアを出力
                                    for ($k = 0; $k < count($score_list[$i][$j]); $k++) {
                                        if (count($score_list[$i][$j][$k]) != 0) {
                                            // ボタン（form）
                                            $form_edit = '
                                                <form class = "form2" method = "POST" action = "score_edit.php">
                                                    <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                                    <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                                    <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                                    <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $student_table_id . '">
                                                    <input type = "number" name = "score_grade" style = "display: none;" value = "' . (string)$i . '">
                                                    <input type = "number" name = "score_term" style = "display: none;" value = "' . (string)$j . '">
                                                    <input type = "number" name = "score_subject" style = "display: none;" value = "' . (string)$k . '">
                                                    <button type = "submit">修正</button>
                                                </form>
                                            ';

                                            // ボタン（form）
                                            $form_delete = '
                                                <form class = "form2" method = "POST" action = "score_delete.php">
                                                    <input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">
                                                    <input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">
                                                    <input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">
                                                    <input type = "number" name = "student_table_id" style = "display: none;" value = "' . $student_table_id . '">
                                                    <input type = "number" name = "score_grade" style = "display: none;" value = "' . (string)$i . '">
                                                    <input type = "number" name = "score_term" style = "display: none;" value = "' . (string)$j . '">
                                                    <input type = "number" name = "score_subject" style = "display: none;" value = "' . (string)$k . '">
                                                    <button type = "submit">削除</button>
                                                </form>
                                            ';

                                            // 詳細
                                            echo '<tr class = "tr-sub">';
                                                echo '<td class = "td-sub-score">' . $subject_list[(int)$score_list[$i][$j][$k]['subject']] . '</td>';
                                                echo '<td class = "td-sub-score">' . $score_list[$i][$j][$k]['score'] . '</td>';
                                                echo '<td class = "td-sub-score">' . $score_list[$i][$j][$k]['average'] . '</td>';
                                                echo '<td class = "td-sub-score">' . $score_list[$i][$j][$k]['deviation'] . '</td>';
                                                echo '<td class = "td-sub-score">' . $form_edit . '</td>';
                                                echo '<td class = "td-sub-score">' . $form_delete . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                }
                            }
                            echo '</table></td></tr>';
                        }
                    }
                    ?>
                </table>
                
                <?php make_link2('戻る', 'info_student.php', [$user_name, $login_id, $user_pass]) ?>
            </div>
        </main>
    </body>
</html>
