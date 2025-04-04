<?php
include('../common/get_info.php');
include('../common/db_info.php');
include('../common/function.php');

$stamp_list = [];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_table_id = $result['table_id'];

    $sql = 'SELECT * FROM info_stamp WHERE user_table_id = :user_table_id ORDER BY id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_table_id', $user_table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $sql = 'SELECT * FROM info_image WHERE table_id = :table_id AND img_id = :img_id AND stamp_id = :stamp_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $row['director_table_id'], PDO::PARAM_INT);
        $stmt->bindParam(':img_id', $row['img_id'], PDO::PARAM_INT);
        $stmt->bindParam(':stamp_id', $row['stamp_id'], PDO::PARAM_STR);
        $stmt->execute();
        $result_stamp = $stmt->fetch(PDO::FETCH_ASSOC);
        $stamp_list[] = [(string)$result_stamp['table_id'], (string)$result_stamp['img_id'], $result_stamp['img_extention'], $result_stamp['img_title'], $row['get_date'], $row['stamp_id']];
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}

if (count($stamp_list) == 0) {
    $stamp_page_max = 1;
} else if (count($stamp_list) % 9 == 0) {
    $stamp_page_max = intdiv(count($stamp_list), 9);
} else {
    $stamp_page_max = intdiv(count($stamp_list), 9) + 1;
}

if ($_POST['stamp-page-position'] == '') {
    $stamp_page_position = $stamp_page_max - 1;
} else {
    $stamp_page_position = (int)$_POST['stamp-page-position'];
}

if ($stamp_page_position == $stamp_page_max) {
    $add_count = 0;
} else if ($stamp_page_position == $stamp_page_max - 1) {
    if (count($stamp_list) == 0) {
        $add_count = 0;
    } else if (count($stamp_list) % 9 == 0) {
        $add_count = 9;
    } else {
        $add_count = count($stamp_list) % 9;
    }
} else {
    $add_count = 9;
}

include('../common/banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>スタンプカード</title>
        <meta name = "description" content = "スタンプカード">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/detail_stamp.css" rel = "stylesheet">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/set-banner.js"></script>
        <script src = "../common/js/check-submit.js"></script>
        <?php if ($banner == '8') { ?>
            <script src = "../common/js/set-stamp.js"></script>
        <?php } ?>
        <script>
            window.addEventListener('load', () => {
                const options = {
                    duration: 500,
                    easing: 'ease',
                    fill: 'forwards',
                };
                const openDetail = {
                    translate: ['-50% -50%', '-50% -50%'],
                    transform: ['rotate3d(0, 1, 0, 180deg)', 'rotate3d(0, 1, 0, 0deg)'],
                    opacity: [0, 1],
                };
                const closeDetail = {
                    translate: ['-50% -50%', '-50% -50%'],
                    transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(0, 1, 0, 0deg)'],
                    opacity: [1, 0],
                };
                const checkDetail = document.querySelector('.main-stamp-detail-check');

                <?php for ($i = 9 * $stamp_page_position; $i < (9 * $stamp_page_position) + $add_count; $i += 1) { ?>
                
                const openButton<?php echo (string)$i; ?> = document.querySelector('.main-stamp-button<?php echo (string)$i; ?>');
                const closeButton<?php echo (string)$i; ?> = document.querySelector('.main-stamp-info-button<?php echo (string)$i; ?>');
                const detail<?php echo (string)$i; ?> = document.querySelector('.main-stamp-info<?php echo (string)$i; ?>');

                openButton<?php echo (string)$i; ?>.addEventListener('click', () => {
                    if (detail<?php echo (string)$i; ?>.style.display === 'none' && checkDetail.textContent === 'none') {
                        detail<?php echo (string)$i; ?>.style.display = 'flex';
                        checkDetail.textContent = 'set';
                        detail<?php echo (string)$i; ?>.animate(openDetail, options);
                    }
                });

                closeButton<?php echo (string)$i; ?>.addEventListener('click', () => {
                    if (detail<?php echo (string)$i; ?>.style.display === 'flex') {
                        checkDetail.textContent = 'none';
                        detail<?php echo (string)$i; ?>.animate(closeDetail, options);
                        setTimeout(() => {
                            detail<?php echo (string)$i; ?>.style.display = 'none';
                        }, '500');
                    }
                });
                <?php } ?>
            });
        </script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-stamp-detail-check" style = "display: none;">none</p>
                <?php
                if ($banner == '8') {
                    echo '<p class = "main-stamp-detail-get" style = "display: none;">new</p>';
                } else {
                    echo '<p class = "main-stamp-detail-get" style = "display: none;">none</p>';
                }
                ?>
                <p class = "main-block-title">スタンプカード</p>
                <div class = "main-stamp-area">
                    <table class = "main-stamp-table">
                        <?php
                        for ($i = 9 * $stamp_page_position; $i < (9 * $stamp_page_position) + 9; $i += 1) {
                            if ($i % 3 == 0) {echo '<tr>';}
                            echo '<td>';
                                if ($i < count($stamp_list)) {
                                    echo '<div class = "main-stamp-back" style = "border: none;"><p style = "display: none;">' . (string)($i + 1) . '</p></div>';
                                    if ($stamp_list[$i][5] == 'none') {
                                        echo '<button class = "main-stamp-button' . (string)$i . ' main-stamp-button"><img class = "main-stamp" src = "../d/images_stamp/' . $stamp_list[$i][0] . '_' . $stamp_list[$i][1] . '.' . $stamp_list[$i][2] . '?version=' . uniqid()  . '"></button>';
                                    } else {
                                        echo '<button class = "main-stamp-button' . (string)$i . ' main-stamp-button"><img class = "main-stamp" src = "../d/images_stamp/' . $stamp_list[$i][0] . '_' . $stamp_list[$i][1] . '_' . $stamp_list[$i][5] . '.' . $stamp_list[$i][2] . '?version=' . uniqid()  . '"></button>';
                                    }
                                } else {
                                    echo '<div class = "main-stamp-back"><p>' . (string)($i + 1) . '</p></div>';
                                    echo '<button class = "main-stamp-button' . (string)$i . ' main-stamp-button" style = "pointer-events: none;"></button>';
                                }
                            echo '</td>';
                            if ($i % 3 == 2) {echo '</tr>';}
                        }
                        ?>
                    </table>
                </div>

                <?php
                if (count($stamp_list) != 0 && $stamp_page_position != $stamp_page_max) {
                    for ($i = 9 * $stamp_page_position; $i < (9 * $stamp_page_position) + $add_count; $i += 1) {
                        echo '<div class = "main-stamp-info' . (string)$i . ' main-stamp-info" style = "display: none">';
                            if ($stamp_list[$i][5] == 'none') {
                                echo '<img class = "main-stamp-info-img" src = "../d/images_stamp/' . $stamp_list[$i][0] . '_' . $stamp_list[$i][1] . '.' . $stamp_list[$i][2] . '?version=' . uniqid() . '">';
                            } else {
                                echo '<img class = "main-stamp-info-img" src = "../d/images_stamp/' . $stamp_list[$i][0] . '_' . $stamp_list[$i][1] . '_' . $stamp_list[$i][5] . '.' . $stamp_list[$i][2] . '?version=' . uniqid() . '">';
                            }
                            echo '<p class = "main-stamp-info-title">' . $stamp_list[$i][3] . '</p>';
                            echo '<p class = "main-stamp-info-date">取得日：' . $stamp_list[$i][4] . '</p>';
                            echo '<form method = "post" action = "delete_stamp.php" onSubmit = "return checkSubmit3()">';
                                echo '<input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">';
                                echo '<input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">';
                                echo '<input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">';
                                echo '<input type = "text" name = "delete_stamp_id" style = "display: none;" value = "' . (string)$i . '">';
                                echo '<button class = "main-stamp-delete-button' . (string)$i . ' main-stamp-delete-button"><p>削除</p></button>';
                            echo '</form>';
                            echo '<button class = "main-stamp-info-button' . (string)$i . ' main-stamp-info-button"><p>閉じる</p></button>';
                        echo '</div>';
                        
                        if (($i + 1) == count($stamp_list)) {
                            echo '<p class = "stamp-last-number" style = "display: none;">' . (string)$i . '</p>';
                        }
                    }
                }
                ?>
                
                <div class = "main-stamp-page-count">
                    <p><?php echo (string)($stamp_page_position + 1) . ' / ' . (string)($stamp_page_max + 1); ?></p>
                </div>

                <div class = "main-stamp-slide">
                    <form class = "main-stamp-slide-left" method = "POST" action = "./detail_stamp.php">
                        <input type = "text" name = "user_name"  style = "display: none;" value = "<?php echo $user_name; ?>">
                        <input type = "text" name = "login_id"  style = "display: none;" value = "<?php echo $login_id; ?>">
                        <input type = "text" name = "user_pass"  style = "display: none;" value = "<?php echo $user_pass; ?>">
                        <input type = "number" name = "stamp-page-position" style = "display: none;" value = "<?php echo (string)($stamp_page_position - 1); ?>">
                        <?php
                        if ($stamp_page_position == 0) {
                            echo '<button class = "slide-button-left" style = "pointer-events: none;"><p>←</p></button>';
                        } else {
                            echo '<button class = "slide-button-left"><p>←</p></button>';
                        }
                        ?>
                    </form>

                    <form class = "main-stamp-slide-right" method = "POST" action = "./detail_stamp.php">
                        <input type = "text" name = "user_name"  style = "display: none;" value = "<?php echo $user_name; ?>">
                        <input type = "text" name = "login_id"  style = "display: none;" value = "<?php echo $login_id; ?>">
                        <input type = "text" name = "user_pass"  style = "display: none;" value = "<?php echo $user_pass; ?>">
                        <input type = "number" name = "stamp-page-position" style = "display: none;" value = "<?php echo (string)($stamp_page_position + 1); ?>">
                        <?php
                        if ($stamp_page_position == $stamp_page_max) {
                            echo '<button class = "slide-button-right" style = "pointer-events: none;"><p>→</p></button>';
                        } else {
                            echo '<button class = "slide-button-right"><p>→</p></button>';
                        }
                        ?>
                    </form>
                </div>

                <form class = "main-form-qr" method = "post" action = "read_qr.php">
                    <?php
                    echo '<input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">';
                    echo '<input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">';
                    echo '<input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">';
                    ?>
                    <button class = "main-form-qr-button" type = "submit"><p>スタンプを取得する</p></button>
                </form>
            </div>
        </main>
    </body>
</html>
