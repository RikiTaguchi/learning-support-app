<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('./set_book.php');
include('./source_book.php');

$account_type = ['h'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

$start = $_POST['start'];
$end = $_POST['end'];
$questions_num = $_POST['questions_num'];
$order = $_POST['order'];

if (check_form($_POST['book_id'], $start, $end, $questions_num, $limit) == 1) {
    header('Location: form.php?banner=21', true, 307);
    exit;
} else if (check_form($_POST['book_id'], $start, $end, $questions_num, $limit) == 2) {
    header('Location: form.php?banner=22', true, 307);
    exit;
} else if (check_form($_POST['book_id'], $start, $end, $questions_num, $limit) == 3) {
    header('Location: form.php?banner=20', true, 307);
    exit;
}

$number = [];
$words = [];
$answers = [];
$select1 = [];
$select2 = [];
$select3 = [];
$select4 = [];
$type = [];

if ($order == 1) {
    $i = 1;
    while ($i <= $questions_num) {
        $sample = rand($start, $end);
        $check = 0;
        foreach ($number as $x) {
            if ($sample == $x) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $number[] = $sample;
            $i++;
        }
    }
}
else if ($order == 2) {
    for ($i = $start; $i <= $end; $i++) {
        $number[] = $i;
    }
}
else {
    header('Location: index.php?banner=9', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    foreach ($number as $n) {
        if (array_search($book_id, $book_id_list) === false) {
            $sql = 'SELECT * FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
            $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
            $stmt->bindParam(':question_number', $n, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql = 'SELECT * FROM ' . $book_id . ' WHERE id = :id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $n, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $words[] = $result['word'];
        $answers[] = $result['answer'];
        if ($book_id == 'Vintage') {
            $select1[] = $result['select1'];
            $select2[] = $result['select2'];
            $select3[] = $result['select3'];
            $select4[] = $result['select4'];
            $type[] = $result['type'];
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
    <meta name = "description" content = "テスト(問題)">
    <meta name = "viewport" content = "width=device-width">
    <link href = "../common/css/set.css?v=1.0.0" rel = "stylesheet">
    <link href = "../common/css/set_print.css?v=1.0.0" rel = "stylesheet" media = "print">
    <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
    <link rel = "manifest" href = "../common/icons/manifest.json">
    <link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
    <link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
    <link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
    <link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <header class = "header">
        <form class = "header-top" method = "post" action = "index.php">
            <?php
            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
            ?>
            <button class = "header-logo" type = "submit">
                <img src = "../common/images/meiko-logo.png" alt = "ロゴ画像">
            </button>
        </form>
        <div class = "header-inner-menu">
            <?php
            echo '<p class = "header-inner-menu-title">' . $book_name . ' / #' . $start . '~' . $end . ' / ' . $questions_num . '題</p>'. PHP_EOL;
            echo '<div class = "header-inner-menu-button">';
                echo '<form method = "post" action = "answer.php?book_name=' . $book_name . '&book_id=' . $book_id . '&start=' . $start . '&end=' . $end . '&questions_num=' . $questions_num . '&';
                for ($i = 1; $i <= $questions_num; $i++) {
                    echo 'data' . $i . '=' . $number[$i - 1];
                    if ($i < $questions_num) {
                        echo '&';
                    }
                    else {
                        echo '">';
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        echo '<button class = "make-link-button" type = "submit">';
                            echo '<p>解答</p>';
                        echo '</button>';
                        echo '</form>';
                    }
                }
                echo '<form>';
                    echo '<button type = "button" onclick="window.print()">';
                        echo '<p>印刷</p>';
                    echo '</button>';
                echo '</form>';
                make_link('戻る', 'form.php', [$user_name, $login_id, $user_pass]);
            ?>
            </div>
        </div>
    </header>
    <main>
        <div class = "main-inner">
            <?php
            for ($i = 0; $i < $questions_num; $i++) {
                if (($i + 1) % 10 == 0) {
                    if ($book_id == 'Vintage') {
                        echo '<p class = "main-inner-word-change-sub">';
                    } else {
                        echo '<p class = "main-inner-word-change">';
                    }
                } else {
                    if ($book_id == 'Vintage') {
                        echo '<p class = "main-inner-word-sub">';
                    } else {
                        echo '<p class = "main-inner-word">';
                    }
                }
                if ($book_id == 'Vintage') {
                    if ($type[$i] == 0 or $type[$i] == 1) {
                        echo $i + 1 . '.　' . str_replace('<br><br>', '<br>　　', $words[$i]) . '<br><br>　　①' . $select1[$i] . '　②' . $select2[$i] . '　③' . $select3[$i] . '　④' . $select4[$i] . '<br><hr>';
                    } else {
                        echo $i + 1 . '.　' . str_replace('<br><br>', '<br>　　', $words[$i]) . '<br><br><br><hr>';
                    }
                    echo '</p>';
                }
                else {
                    echo $i + 1 . '. ' . str_replace('<br>', ' / ', $words[$i]) . ' (' . $number[$i] . ')<br><hr>';
                    echo '</p>';
                }
            }
            ?>
        </div>
    </main>
</body>
</html>
