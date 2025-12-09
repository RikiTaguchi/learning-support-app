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

// 成績情報を取得
$grade = $_POST['score_grade'];
$term = $_POST['score_term'];
$subject = $_POST['score_subject'];

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

    // 成績情報の取得
    $sql = 'SELECT * FROM info_score WHERE table_id = :table_id AND grade = :grade AND term = :term AND subject = :subject';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $student_table_id, PDO::PARAM_INT);
    $stmt->bindParam(':grade', $grade, PDO::PARAM_INT);
    $stmt->bindParam(':term', $term, PDO::PARAM_INT);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_INT);
    $stmt->execute();
    $result_score = $stmt->fetch(PDO::FETCH_ASSOC);

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
        <meta name = "description" content = "成績情報更新">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/form.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/header.css?v=1.0.2" rel = "stylesheet">
        <link href = "../common/css/body.css?v=1.0.3" rel = "stylesheet">
        <link href = "../common/css/edit_student.css?v=1.0.0" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js?v=1.0.2"></script>
        <script src = "../common/js/set-banner.js?v=1.0.4"></script>
        <script src = "../common/js/disable-form.js?v=1.0.0"></script>
        <script src = "../common/js/check-submit.js?v=1.0.4"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title"><?php echo $student_user_name; ?></p>

                <form class = "form" method = "POST" action = "score_edit_check.php" autocomplete="off">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <input type = "number" name = "student_table_id" style = "display: none;" value = "<?php echo $student_table_id; ?>">
                    
                    <div class = "form-content-3">
                        <span>学年</span><br>
                        <select class = "form-grade" name = "score_grade" style = "background-color: #eee; color: #555; pointer-events: none;" readonly required>
                            <option value = "0" <?php if ($grade === '0') echo 'selected'; ?>>小学1年</option>
                            <option value = "1" <?php if ($grade === '1') echo 'selected'; ?>>小学2年</option>
                            <option value = "2" <?php if ($grade === '2') echo 'selected'; ?>>小学3年</option>
                            <option value = "3" <?php if ($grade === '3') echo 'selected'; ?>>小学4年</option>
                            <option value = "4" <?php if ($grade === '4') echo 'selected'; ?>>小学5年</option>
                            <option value = "5" <?php if ($grade === '5') echo 'selected'; ?>>小学6年</option>
                            <option value = "6" <?php if ($grade === '6') echo 'selected'; ?>>中学1年</option>
                            <option value = "7" <?php if ($grade === '7') echo 'selected'; ?>>中学2年</option>
                            <option value = "8" <?php if ($grade === '8') echo 'selected'; ?>>中学3年</option>
                            <option value = "9" <?php if ($grade === '9') echo 'selected'; ?>>高校1年</option>
                            <option value = "10" <?php if ($grade === '10') echo 'selected'; ?>>高校2年</option>
                            <option value = "11" <?php if ($grade === '11') echo 'selected'; ?>>高校3年</option>
                            <option value = "12" <?php if ($grade === '12') echo 'selected'; ?>>その他</option>
                        </select>
                    </div>
                    <div class = "form-content-3">
                        <span>種別</span><br>
                        <select class = "form-term" name = "score_term" style = "background-color: #eee; color: #555; pointer-events: none;" readonly required>
                            <option value = "0" <?php if ($term === '0') echo 'selected'; ?>>前期中間</option>
                            <option value = "1" <?php if ($term === '1') echo 'selected'; ?>>前期期末</option>
                            <option value = "2" <?php if ($term === '2') echo 'selected'; ?>>後期中間</option>
                            <option value = "3" <?php if ($term === '3') echo 'selected'; ?>>後期期末(学年末)</option>
                            <option value = "4" <?php if ($term === '4') echo 'selected'; ?>>1学期中間</option>
                            <option value = "5" <?php if ($term === '5') echo 'selected'; ?>>1学期期末</option>
                            <option value = "6" <?php if ($term === '6') echo 'selected'; ?>>2学期中間</option>
                            <option value = "7" <?php if ($term === '7') echo 'selected'; ?>>2学期期末</option>
                            <option value = "8" <?php if ($term === '8') echo 'selected'; ?>>3学期期末(学年末)</option>
                            <option value = "9" <?php if ($term === '9') echo 'selected'; ?>>その他</option>
                        </select>
                    </div>
                    <div class = "form-content-3">
                        <span>科目</span><br>
                        <select class = "form-subject" name = "score_subject" style = "background-color: #eee; color: #555; pointer-events: none;" readonly required>
                            <option value = "0" <?php if ($subject === '0') echo 'selected'; ?>>国語(小学生)</option>
                            <option value = "1" <?php if ($subject === '1') echo 'selected'; ?>>算数(小学生)</option>
                            <option value = "2" <?php if ($subject === '2') echo 'selected'; ?>>英語(小学生)</option>
                            <option value = "3" <?php if ($subject === '3') echo 'selected'; ?>>理科(小学生)</option>
                            <option value = "4" <?php if ($subject === '4') echo 'selected'; ?>>社会(小学生)</option>
                            <option value = "5" <?php if ($subject === '5') echo 'selected'; ?>>国語(中学生)</option>
                            <option value = "6" <?php if ($subject === '6') echo 'selected'; ?>>数学(中学生)</option>
                            <option value = "7" <?php if ($subject === '7') echo 'selected'; ?>>英語(中学生)</option>
                            <option value = "8" <?php if ($subject === '8') echo 'selected'; ?>>理科(中学生)</option>
                            <option value = "9" <?php if ($subject === '9') echo 'selected'; ?>>社会(中学生)</option>
                            <option value = "10" <?php if ($subject === '10') echo 'selected'; ?>>音楽(中学生)</option>
                            <option value = "11" <?php if ($subject === '11') echo 'selected'; ?>>美術(中学生)</option>
                            <option value = "12" <?php if ($subject === '12') echo 'selected'; ?>>技術家庭(中学生)</option>
                            <option value = "13" <?php if ($subject === '13') echo 'selected'; ?>>保健体育(中学生)</option>
                            <option value = "14" <?php if ($subject === '14') echo 'selected'; ?>>その他</option>
                        </select>
                    </div>
                    
                    <div class = "form-content-3">
                        <span>得点</span>
                        <input class = "form-point" type = "number" name = "score_point" value = "<?php echo $result_score['score']; ?>" required>
                    </div>
                    <div class = "form-content-3">
                        <span>平均点</span>
                        <input class = "form-average" type = "number" name = "score_average" value = "<?php echo $result_score['average']; ?>">
                    </div>
                    <div class = "form-content-3">
                        <span>偏差値</span>
                        <input class = "form-deviation" type = "number" name = "score_deviation" value = "<?php echo $result_score['deviation']; ?>">
                    </div>
                    <div class = "form-content">
                        <div class = "form-content-submit">
                            <button type = "submit" name = "submit">更新</button>
                        </div>
                    </div>
                </form>

                <form class = "form" method = "POST" action = "score_delete.php" autocomplete="off"  onSubmit = "return checkSubmit5();">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id; ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass; ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name; ?>">
                    <input type = "number" name = "student_table_id" style = "display: none;" value = "<?php echo $student_table_id; ?>">
                    <input type = "number" name = "score_grade" style = "display: none;" value = "<?php echo $grade; ?>">
                    <input type = "number" name = "score_term" style = "display: none;" value = "<?php echo $term; ?>">
                    <input type = "number" name = "score_subject" style = "display: none;" value = "<?php echo $subject; ?>">
                    
                    <div class = "form-content">
                        <div class = "form-content-submit">
                            <button type = "submit" name = "submit">削除</button>
                        </div>
                    </div>
                </form>
                
                <?php make_link3('戻る', 'score_info.php', [$user_name, $login_id, $user_pass, $student_table_id]) ?>
            </div>
        </main>
    </body>
</html>
