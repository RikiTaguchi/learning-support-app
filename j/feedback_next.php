<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');
include('./source_book.php');

$book_id = $_POST['book_id'];
$book_name = $_POST['book_name'];
$order = $_POST['order'];
$questions_num = $_POST['questions_num'];
$n = (int)$_POST['next_number'];
$key_submit = explode('(and)',$_POST['submit_order']);
$selected = $key_submit[0];
$selected_id = $key_submit[1];
if ($_POST['submit'] == 'Next') {
    $n = $n + 1;
}
else if ($_POST['submit'] == 'Back') {
    $n = $n - 1;
}
$number = [];
for ($i = 0; $i < $questions_num; $i ++) {
    $number[] = $_POST['question_number' . $i]; 
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

    $sql = 'SELECT * FROM info_feedback WHERE table_id = :table_id AND book_id = :book_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $check_feedback = false;
    foreach ($result as $row) {
        if ($number[$n] == $row['question_number']) {
            $check_feedback = true;
            break;
        }
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (array_search($book_id, $book_id_list) == false) {
        $sql = 'SELECT * FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':question_number', $number[$n], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $sql = 'SELECT * FROM ' . $book_id . ' WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $number[$n], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    $word = $result['word'];
    $answer = $result['answer'];
    if ($book_id == 'meiko_original_2') {
        $select1 = $result['select1'];
        $select2 = $result['select2'];
        $select3 = $result['select3'];
        $select4 = $result['select4'];
        $type = $result['type'];
    }
    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<head lang = "ja">
    <meta charset = "UTF-8">
    <title>復習モード</title>
    <meta name = "description" content = "復習モード">
    <meta name = "viewport" content = "width=device-width">
    <link href = "../common/css/header.css" rel = "stylesheet">
    <link href = "../common/css/body.css" rel = "stylesheet">
    <link href = "../common/css/training.css" rel = "stylesheet">
    <script src = "../common/js/toggle-menu.js"></script>
    <script src = "../common/js/toggle-panel.js"></script>
    <script src = "../common/js/slide-panel.js"></script>
    <script src = "../common/js/change-question.js"></script>
    <script src = "../common/js/toggle-feedback2.js"></script>
</head>
<body>
    <header class = "header">
        <?php include('./header.php'); ?>
        <div class = "main-notice-feedback"><p class = "main-notice-feedback-text"></p></div>
    </header>
    <main>
        <div class = "main-block">
            <?php
            echo '<p class = "main-block-title">' . $book_name . ' / 復習モード</p>'. PHP_EOL;
            echo '<p class = "main-block-subtitle">' . (string)(((int)$n) + 1) . ' / ' . $questions_num . '</p>';
            echo '<p class = "info-bookname" style = "display: none;">' . $book_name . '</p>';
            echo '<p class = "info-type" style = "display: none;">' . $type . '</p>';
            if ($book_id == 'meiko_original_2') {
                echo '<div class = "main-inner-selectmenu">';
                echo '<p class = "main-inner-word-select">' . str_replace('<br><br>', '<br>', $word) . '</p>' . PHP_EOL;
                echo '<div class = "main-inner-answer-menu">';
                if ($type == 2) {
                    $choices = explode('/ ', $select1);
                    $x = explode('+', $selected);
                    $y = $selected_id;
                    echo '<p class = "main-inner-answer-menu-choices-order">';
                        if ($x[0] != 'Next' && $x[0] != 'Back') {
                            echo $x[0];
                        }
                    echo '</p>';
                    echo '<form class = "main-inner-submit-order" method = "post" action = "feedback_next.php">';
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        echo '<div class = "main-inner-answer-menu-choices">';
                        echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                        echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                        echo '<input type = "number" name = "order" value = "' . $order . '">';
                        echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                        for ($i = 0; $i < $questions_num; $i ++) {
                            echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                        }
                        echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                        for ($c = 0; $c < count($choices); $c += 1) {
                            if (count($x) == 1) {
                                $str_start = $choices[$c];
                                if (substr($word, 0, 1) == '(' || $book_name == 'meiko_original_2') {
                                    $str_start = strtoupper(substr($str_start, 0, 1)) . substr($str_start, 1, (strlen($str_start) - 1));
                                }
                                $selected = $str_start . '+' . $choices[$c];
                                $selected_id = '(' . $c . ')'; 
                                echo '<button class = "main-inner-answer-menu-choice is-show" type = "submit" name = "submit_order" value = "' . $selected . '(and)' . $selected_id . '">' . $choices[$c] . '</button>';
                            } else {
                                $selected = $x[0] . ' ' . $choices[$c] . '+' . $choices[$c];
                                $selected_id = $y . '+(' . $c . ')';
                                if (preg_match('/' . $choices[$c] . '/', $x[0]) || preg_match('/' . strtoupper(substr($choices[$c], 0, 1)) . substr($choices[$c], 1, (strlen($choices[$c]) - 1)) . '/', $x[0])) {
                                    if (preg_match('/(' . $c . ')/', $y)) {
                                        echo '<button class = "main-inner-answer-menu-choice" type = "submit" name = "submit_order" value = "' . $selected . '(and)' . $selected_id . '">' . $choices[$c] . '</button>';
                                    } else {
                                        echo '<button class = "main-inner-answer-menu-choice is-show" type = "submit" name = "submit_order" value = "' . $selected . '(and)' . $selected_id . '">' . $choices[$c] . '</button>';
                                    }
                                } else {
                                    echo '<button class = "main-inner-answer-menu-choice is-show" type = "submit" name = "submit_order" value = "' . $selected . '(and)' . $selected_id . '">' . $choices[$c] . '</button>';
                                }
                            }
                        }
                        echo '</div>';
                        echo '<button class = "main-inner-answer-menu-choice0" type = "submit" name = "submit_order" value = "">Clear</button>';
                    echo '</form>';
                }
                echo '<form class = "main-inner-select" method = "post" action = "feedback_answer.php">';
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                    echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                    echo '<input type = "number" name = "start" value = "' . $start . '">';
                    echo '<input type = "number" name = "end" value = "' . $end . '">';
                    echo '<input type = "number" name = "order" value = "' . $order . '">';
                    echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                    for ($i = 0; $i < $questions_num; $i ++) {
                        echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                    }
                    echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                    if ($type == 0 or $type == 1) {
                        echo '<p><button class = "main-inner-answer-menu-select1" type = "submit" name = "submit" value = "1">' . $select1 . '</button></p>';
                        echo '<p><button class = "main-inner-answer-menu-select2" type = "submit" name = "submit" value = "2">' . $select2 . '</button></p>';
                        echo '<p><button class = "main-inner-answer-menu-select3" type = "submit" name = "submit" value = "3">' . $select3 . '</button></p>';
                        echo '<p><button class = "main-inner-answer-menu-select4" type = "submit" name = "submit" value = "4">' . $select4 . '</button></p>';
                    } else if ($type == 2) {
                        echo '<input type = "text" name = "input-text" value = "' . $x[0] . '">';
                        echo '<div><button class = "main-inner-answer-menu-nonselect" type = "submit" name = "submit" value = "0">Check the answer</button></div>';
                    } else {
                        echo '<input class = "main-inner-answer-menu-input" type = "text" name = "input-text">';
                        echo '<div><button class = "main-inner-answer-menu-nonselect" type = "submit" name = "submit" value = "0">Check the answer</button></div>';
                    }
                echo '</form>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class = "question-panel">';
                    echo '<button class = "main-inner-toggle-word main-inner-toggle-answer main-inner-toggle-button">';
                        echo '<p class = "main-inner-word" style = "display: block;">' . $word . '</p>' . PHP_EOL;
                        echo '<p class = "main-inner-answer" style = "display: none;">' . $answer . '</p>' . PHP_EOL;
                        if ($check_feedback == true) {
                            echo '<div class = "main-inner-mark-feedback"><p>復</p></div>';
                        }
                    echo '</button>';
                echo '</div>';
            }
            
            if ($book_name != 'meiko_original_2') {
                echo '<form class = "feedback-list" method = "post" action = "feedback_delete.php">';
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                    echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                    echo '<input type = "number" name = "start" value = "' . $start . '">';
                    echo '<input type = "number" name = "end" value = "' . $end . '">';
                    echo '<input type = "number" name = "order" value = "' . $order . '">';
                    echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                    for ($i = 0; $i < $questions_num; $i ++) {
                        echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                    }
                    echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                    if ($type == 2) {
                        echo '<input class = "main-inner-answer-menu-order" type = "text" name = "input-text" value = "' . $x[0] . '">';
                    }
                    echo '<input type = "text" name = "submit_order" value = "' . $_POST['submit_order'] . '">';
                    echo '<input type = "text" name = "qanda" value = "q">';

                    echo '<input type = "text" name = "info-feedback" value = "feedback" style = "display: none;">';
                    echo '<p class = "info-feedback-text" style = "display: none;">' . $_POST['info-feedback'] . '</p>';

                    if ($check_feedback) {
                        echo '<button class = "btn-feedback" type = "submit">復習リストから削除</button>';
                    } else {
                        echo '<button class = "btn-feedback" type = "submit" style = "pointer-events: none;">復習リストから削除済</button>';
                    }

                echo '</form>';
            } else {
                echo '<form class = "feedback-list2" method = "post" action = "feedback_delete.php">';
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                    echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                    echo '<input type = "number" name = "start" value = "' . $start . '">';
                    echo '<input type = "number" name = "end" value = "' . $end . '">';
                    echo '<input type = "number" name = "order" value = "' . $order . '">';
                    echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                    for ($i = 0; $i < $questions_num; $i ++) {
                        echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                    }
                    echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                    if ($type == 2) {
                        echo '<input class = "main-inner-answer-menu-order" type = "text" name = "input-text" value = "' . $x[0] . '">';
                    }
                    echo '<input type = "text" name = "submit_order" value = "' . $_POST['submit_order'] . '">';
                    echo '<input type = "text" name = "qanda" value = "q">';

                    echo '<input type = "text" name = "info-feedback" value = "feedback" style = "display: none;">';
                    echo '<p class = "info-feedback-text" style = "display: none;">' . $_POST['info-feedback'] . '</p>';

                    if ($check_feedback) {
                        echo '<button class = "btn-feedback" type = "submit">復習リストから削除</button>';
                    } else {
                        echo '<button class = "btn-feedback" type = "submit" style = "pointer-events: none;">復習リストから削除済</button>';
                    }

                echo '</form>';
            }
            ?>
            <form class = "next-word" method = "post" action = "feedback_next.php">
                <?php
                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                echo '<input type = "number" name = "start" value = "' . $start . '">';
                echo '<input type = "number" name = "end" value = "' . $end . '">';
                echo '<input type = "number" name = "order" value = "' . $order . '">';
                echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                for ($i = 0; $i < $questions_num; $i ++) {
                    echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                }
                echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                echo '<div class = "main-inner-change">';
                if ($n > 0) {
                    echo '<p><input class = "main-inner-submit-back" type = "submit" name = "submit" value = "Back"></p>';
                } else {
                    echo '<p><input class = "main-inner-submit-back main-inner-submit-disabled" type = "submit" name = "submit" value = "Back" disabled></p>';
                }
                if ($n < (int)$questions_num - 1) {
                    echo '<p><input class = "main-inner-submit-next" type = "submit" name = "submit" value = "Next"></p>';
                } else {
                    echo '<p><input class = "main-inner-submit-next main-inner-submit-disabled" type = "submit" name = "submit" value = "Next" disabled></p>';
                }
                echo '</div>';
                ?>
            </form>
            <?php
            echo '<p class = "info-submit" style = "display: none;">' . $_POST['submit'] . '</p>';
            ?>
        </div>
    </main>
</body>
</html>
