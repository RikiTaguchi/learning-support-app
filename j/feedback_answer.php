<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('./source_book.php');

$account_type = ['j'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$login_streak = get_streak($login_id, $db_host, $db_name, $db_user, $db_pass);

$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$start = $_POST['start'];
$end = $_POST['end'];
$order = $_POST['order'];
$questions_num = $_POST['questions_num'];
$n = (int)$_POST['next_number'];
$number = [];
for ($i = 0; $i < $questions_num; $i ++) {
    $number[] = $_POST['question_number' . $i]; 
}
$selected = $_POST['submit'];
$input_text = $_POST['input-text'];

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
    header('Location: login.php?banner=9', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (array_search($book_id, $book_id_list) === false) {
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
        if ($type == 2 || $type == 3 || $type == 4) {
            $answer_text = $_POST['input-text'];
        }
    }
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<head lang = "ja">
    <meta charset = "UTF-8">
    <title>単語システム</title>
    <meta name = "description" content = "復習モード">
    <meta name = "viewport" content = "width=device-width">
    <link href = "../common/css/header.css?v=1.0.0" rel = "stylesheet">
    <link href = "../common/css/body.css?v=1.0.0" rel = "stylesheet">
    <link href = "../common/css/training_answer.css?v=1.0.0" rel = "stylesheet">
    <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
    <link rel = "manifest" href = "../common/icons/manifest.json">
    <link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
    <link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
    <link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
    <link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
    <meta name="theme-color" content="#ffffff">
    <script src = "../common/js/toggle-menu.js?v=1.0.0"></script>
    <script src = "../common/js/change-answer.js?v=1.0.0"></script>
    <script src = "../common/js/set-banner.js?v=1.0.2"></script>
</head>
<body>
    <header class = "header">
        <?php include('./header.php'); ?>
    </header>
    <main>
        <div class = "main-block">
            <?php
            echo '<p class = "info-bookname" style = "display: none;">' . $book_name . '</p>';
            echo '<p class = "main-block-title">' . $book_name . ' / 復習モード</p>' . PHP_EOL;
            echo '<p class = "main-block-subtitle">' . (string)(((int)$n) + 1) . ' / ' . $questions_num . '</p>';
            if ($book_id == 'meiko_original_2') {
                echo '<p class = "main-inner-word-select">' . str_replace('<br><br>', '<br>', $word) . '</p>' . PHP_EOL;
                echo '<div class = "main-inner-answer-menu">';
                if ($type == 0) {
                    if ($selected == $answer) {
                        if ($answer == 1) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button></p>';
                        }
                        if ($answer == 2) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button></p>';
                        }
                        if ($answer == 3) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button></p>';
                        }
                        if ($answer == 4) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button></p>';
                        }
                    } else {
                        if ($answer == 1) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button></p>';
                        } else if ($selected == 1) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button></p>';
                        }
                        if ($answer == 2) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button></p>';
                        } else if ($selected == 2) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button></p>';
                        }
                        if ($answer == 3) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button></p>';
                        } else if ($selected == 3) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button></p>';
                        }
                        if ($answer == 4) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button></p>';
                        } else if ($selected == 4) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button></p>';
                        }
                    }
                } else if ($type == 1) {
                    if ($selected == substr($answer, 0, 1)) {
                        if (substr($answer, 0, 1) == 1) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button></p>';
                        }
                        if (substr($answer, 0, 1) == 2) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button></p>';
                        }
                        if (substr($answer, 0, 1) == 3) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button></p>';
                        }
                        if (substr($answer, 0, 1) == 4) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button>';
                                echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button></p>';
                        }
                    } else {
                        if (substr($answer, 0, 1) == 1) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button></p>';
                        } else if ($selected == 1) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "1" disabled>' . $select1 . '</button></p>';
                        }
                        if (substr($answer, 0, 1) == 2) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button></p>';
                        } else if ($selected == 2) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "2" disabled>' . $select2 . '</button></p>';
                        }
                        if (substr($answer, 0, 1) == 3) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button></p>';
                        } else if ($selected == 3) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "3" disabled>' . $select3 . '</button></p>';
                        }
                        if (substr($answer, 0, 1) == 4) {
                            echo '<p><button class = "main-inner-answer-menu-select" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button></p>';
                        } else if ($selected == 4) {
                            echo '<p>';
                                echo '<button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button>';
                                echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                            echo '</p>';
                        } else {
                            echo '<p><button class = "main-inner-answer-menu-disabled" type = "submit" name = "submit" value = "4" disabled>' . $select4 . '</button></p>';
                        }
                    }
                } else {
                    if ($answer == $input_text) {
                        echo '<p class = "main-inner-input-detail">';
                            echo '<span>' . $input_text . '</span>';
                            echo '<img class = "correct_img" src = "../common/images/correct.png" alt = "正解">';
                        echo '</p>';
                    } else {
                        echo '<p class = "main-inner-input-detail">';
                            echo '<span>' . $input_text . '</span>';
                            echo '<img class = "incorrect_img" src = "../common/images/incorrect.png" alt = "不正解">';
                        echo '</p>';
                    }
                    echo '<p class = "main-inner-selecter-mini">' . $answer . '</p>';
                }

                echo '</div>';
            }
            if ($book_id != 'meiko_original_2') {
                echo '<form class = "feedback-list" method = "post" action = "feedback_delete.php">';
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                    echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                    echo '<input type = "number" name = "order" value = "' . $order . '">';
                    echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                    for ($i = 0; $i < $questions_num; $i ++) {
                        echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                    }
                    echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                    echo '<input class = "main-inner-answer-menu-order" type = "text" name = "input-text" value = "' . $_POST['input-text'] . '">';
                    echo '<input type = "text" name = "submit_order" value = "' . $_POST['submit_order'] . '">';
                    echo '<input type = "text" name = "submit" value = "' . $_POST['submit'] . '">';
                    echo '<input type = "text" name = "qanda" value = "a">';

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
                    echo '<input type = "number" name = "order" value = "' . $order . '">';
                    echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                    for ($i = 0; $i < $questions_num; $i ++) {
                        echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                    }
                    echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                    echo '<input class = "main-inner-answer-menu-order" type = "text" name = "input-text" value = "' . $_POST['input-text'] . '">';
                    echo '<input type = "text" name = "submit_order" value = "' . $_POST['submit_order'] . '">';
                    echo '<input type = "text" name = "submit" value = "' . $_POST['submit'] . '">';
                    echo '<input type = "text" name = "qanda" value = "a">';

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
        </div>

        <div style="margin-top: 20px;">
            <!-- for SP -->
            <script src="https://adm.shinobi.jp/s/b48d915b597d17a79d6d43b4b7c4b69c"></script>
        </div>
    </main>
</body>
</html>
