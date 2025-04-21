<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');

$account_type = ['d'];
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    
    $dbh = null;
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "スタンプ登録">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/form.css" rel = "stylesheet">
        <link href = "../common/css/form_stamp.css" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/set-stamp.js"></script>
        <script src = "../common/js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">スタンプ登録</p>
                <form class = "form" method = "POST" enctype = "multipart/form-data" action = "make_stamp.php">
                    <input type = "text" name = "login_id" style = "display: none;" value = "<?php echo $login_id ?>">
                    <input type = "text" name = "user_pass" style = "display: none;" value = "<?php echo $user_pass ?>">
                    <input type = "text" name = "user_name" style = "display: none;" value = "<?php echo $user_name ?>">
                    <input class = "page-count" type = "text" name = "page_count" style = "display: none;" value = "0">
                    <div class = "form-content">
                        <span>タイトル</span><input type = "text" name = "stamp_title" required>
                    </div>
                    <div class = "form-content-2">
                        <span>タイプ</span>
                        <div>
                            <p><input class = "radio-normal" type = "radio" name = "stamp_style" value = "1" checked>通常</p>
                            <p><input class = "radio-random" type = "radio" name = "stamp_style" value = "2">ガチャ</p>
                        </div>
                    </div>
                    <div class = "form-content">
                        <span>有効期限</span>
                        <input type = "date" name = "date_limit" required>
                    </div>
                    
                    <!-- 通常 -->
                    <div class = "form-normal">
                        <div class = "normal-button">
                            <span>スタンプ</span>
                            <button class = "button-normal" type = "button">
                                <span>ファイルを選択</span>
                                <input class = "file-normal" type = "file" name = "img_data" accept = "image/*" required>
                            </button>
                        </div>
                        <div class = "normal-image">
                            <img class = "preview-normal" src = "../common/images/preview-back.png">
                        </div>
                    </div>

                    <!-- ランダム -->
                    <div class = "form-random" style = "display: none;">
                        <div class = "random-panel">
                            <div class = "random-panel-back">
                                <button type = "button">〈</button>
                            </div>
                            <div class = "random-area" style = "display: flex">
                                <div class = "random-button">
                                    <span>スタンプ１</span>
                                    <button class = "button-random" type = "button">
                                        <span>ファイルを選択</span>
                                        <input class = "file-random" type = "file" name = "img_data_1" accept = "image/*">
                                    </button>
                                </div>
                                <div class = "random-prob">
                                    <span>確率(%)</span>
                                    <input class = "prob-random" type = "number" name = "prob_1">
                                </div>
                                <div class = "random-image">
                                    <img class = "preview-random" src = "../common/images/preview-back.png">
                                </div>
                            </div>
                            <div class = "random-area" style = "display: none;">
                                <div class = "random-button">
                                    <span>スタンプ２</span>
                                    <button class = "button-random" type = "button">
                                        <span>ファイルを選択</span>
                                        <input class = "file-random" type = "file" name = "img_data_2" accept = "image/*">
                                    </button>
                                </div>
                                <div class = "random-prob">
                                    <span>確率(%)</span>
                                    <input class = "prob-random" type = "number" name = "prob_2">
                                </div>
                                <div class = "random-image">
                                    <img class = "preview-random" src = "../common/images/preview-back.png">
                                </div>
                            </div>
                            <div class = "random-area" style = "display: none;">
                                <div class = "random-button">
                                    <span>スタンプ３</span>
                                    <button class = "button-random" type = "button">
                                        <span>ファイルを選択</span>
                                        <input class = "file-random" type = "file" name = "img_data_3" accept = "image/*">
                                    </button>
                                </div>
                                <div class = "random-prob">
                                    <span>確率(%)</span>
                                    <input class = "prob-random" type = "number" name = "prob_3">
                                </div>
                                <div class = "random-image">
                                    <img class = "preview-random" src = "../common/images/preview-back.png">
                                </div>
                            </div>
                            <div class = "random-area" style = "display: none;">
                                <div class = "random-button">
                                    <span>スタンプ４</span>
                                    <button class = "button-random" type = "button">
                                        <span>ファイルを選択</span>
                                        <input class = "file-random" type = "file" name = "img_data_4" accept = "image/*">
                                    </button>
                                </div>
                                <div class = "random-prob">
                                    <span>確率(%)</span>
                                    <input class = "prob-random" type = "number" name = "prob_4">
                                </div>
                                <div class = "random-image">
                                    <img class = "preview-random" src = "../common/images/preview-back.png">
                                </div>
                            </div>
                            <div class = "random-area" style = "display: none;">
                                <div class = "random-button">
                                    <span>スタンプ５</span>
                                    <button class = "button-random" type = "button">
                                        <span>ファイルを選択</span>
                                        <input class = "file-random" type = "file" name = "img_data_5" accept = "image/*">
                                    </button>
                                </div>
                                <div class = "random-prob">
                                    <span>確率(%)</span>
                                    <input class = "prob-random" type = "number" name = "prob_5">
                                </div>
                                <div class = "random-image">
                                    <img class = "preview-random" src = "../common/images/preview-back.png">
                                </div>
                            </div>
                            <div class = "random-panel-next">
                                <button type = "button">〉</button>
                            </div>
                        </div>
                        <div class = "random-count">
                            <div class = "count-block" style = "display: block; background-color: rgb(0, 149, 224);"></div>
                            <div class = "count-block" style = "display: block; background-color: lightgray;"></div>
                            <div class = "count-block" style = "display: none; background-color: lightgray;"></div>
                            <div class = "count-block" style = "display: none; background-color: lightgray;"></div>
                            <div class = "count-block" style = "display: none; background-color: lightgray;"></div>
                        </div>
                        <div class = "random-set">
                            <button class = "set-block set-add" type = "button">＋</button>
                            <button class = "set-block set-remove" type = "button">−</button>
                        </div>
                    </div>
                    
                    <!-- 送信 -->
                    <div class = "form-content">
                        <div class = "form-content-submit"><button class = "stamp-submit" type = "submit">登録</button></div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
