<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');

$type = $_POST['type'];
$level = $_POST['level'];
$question_number = $_POST['question_number'];
$question_count = $_POST['question_count'];
$question_correct = $_POST['question_correct'];

$score = ceil(($question_correct / $question_number) * 100);
if ($score > 100) {
    $score = 100;
} else if ($score < 0) {
    $score = 0;
}

$param_feedback = $_POST['param_feedback'];
$info_feedback = explode('F', $param_feedback);
$list_feedback = [];
for ($i = 1; $i < count($info_feedback); $i += 1) {
    $data0 = explode('E', $info_feedback[$i]);

    $data1 = str_replace('A', '<', $data0[0]);
    $data1 = str_replace('B', '>', $data1);
    $data1 = str_replace('C', ' ', $data1);
    $data1 = str_replace('D', '"', $data1);

    $data2 = str_replace('A', '<', $data0[1]);
    $data2 = str_replace('B', '>', $data2);
    $data2 = str_replace('C', ' ', $data2);
    $data2 = str_replace('D', '"', $data2);

    $data3 = $data0[2];

    $list_feedback[] = [$data1, $data2, $data3];
}

$finish_time_h = $_POST['finish_time_h'];
$finish_time_m = $_POST['finish_time_m'];
$finish_time_s = $_POST['finish_time_s'];
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>計算トレーニング</title>
        <meta name = "description" content = "計算トレーニング">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/math_result.css" rel = "stylesheet">
        <script type = "text/javascript" asyncsrc = "https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=MML_SVG"></script>
        <script src = "../common/js/toggle-menu.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">スコア</p>
                <p class = "result-score"><?php echo (string)$score; ?></p>
                <p class = "result-count"><?php echo $question_correct . '/' . $question_number; ?></p>
                <p class = "result-time"><?php echo $finish_time_h . 'h ' . $finish_time_m . 'm ' . $finish_time_s . 's'; ?></p>

                <?php
                foreach ($list_feedback as $value) {
                    echo '<div class = "feedback-block">';
                        echo '<p class = "feedback-title">[問' . $value[2] . ']</p>';
                        echo '<div class = "feedback-question">' . $value[0] . '</div>';
                        echo '<div class = "feedback-answer">' . $value[1] . '</div>';
                    echo '</div>';
                    echo '<hr class = "feedback-line">';
                }
                ?>

                <form class = "back-area" method = "post" action = "index.php">
                    <input type = "text" name = "login_id" value = "<?php echo $login_id; ?>" style = "display: none;">
                    <input type = "text" name = "user_pass" value = "<?php echo $user_pass; ?>" style = "display: none;">
                    <input type = "text" name = "user_name" value = "<?php echo $user_name; ?>" style = "display: none;">
                    <button class = "back-button" type = "submit">ホームに戻る</button>
                </form>
            </div>
        </main>
    </body>
</html>
