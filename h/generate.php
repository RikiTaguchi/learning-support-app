<?php
include('../common/db_info.php');
include('../common/get_info.php');
include('../common/function.php');
include('../common/banner.php');
include('../common/parser/parse-activator/autoload.php'); // 構文解析器のセットアップ

$account_type = 'h';
check_account_type($login_id, $account_type, $db_host, $db_name, $db_user, $db_pass);

// 特に加工処理をしないタグ
$tags = [
    // 1. 名詞カテゴリー
    'NN', // 普通名詞（単数）
    'NNS', // 普通名詞（複数）
    'NNP', // 固有名詞（単数）
    'NNPS', // 固有名詞（複数）
    
    // 2. 代名詞カテゴリー
    'PRP', // 人称代名詞
    'PRP$', // 所有代名詞
    'WP', // Wh代名詞
    'WP$', // 所有格Wh代名詞
    'EX', // 存在を表す "there"
    
    // 3. 動詞カテゴリー
    'VB', // 動詞（原形）
    'VBD', // 動詞（過去形）
    'VBG', // 動詞（現在分詞）
    'VBN', // 動詞（過去分詞）
    'VBP', // 動詞（現在形）
    'VBZ', // 動詞（三人称単数現在）
    'MD', // 助動詞
    
    // 4. 形容詞カテゴリー
    'JJ', // 形容詞
    'JJR', // 形容詞（比較級）
    'JJS', // 形容詞（最上級）
    
    // 5. 副詞カテゴリー
    'RB', // 副詞
    'RBR', // 副詞（比較級）
    'RBS', // 副詞（最上級）
    'WRB', // Wh副詞
    
    // 6. 前置詞と接続詞カテゴリー
    
    // 7. 限定詞と冠詞カテゴリー
    'DT', // 限定詞
    'PDT', // 前限定詞
    'WDT', // Wh限定詞
    
    // 8. その他の品詞
    'CD', // 基数
    'RP', // 助詞
    'SYM', // 記号
    'TO', // to
    'UH', // 間投詞
    'LS', // リストマーカー
    'FW', // 外国語
    'POS', // 所有格マーカー
    
    // 9. 句構造タグ
    'PP', // 前置詞句
    'ADJP', // 形容詞句
    'ADVP', // 副詞句
    'SBAR', // 従属節
    
    // 10. 文レベルのタグ
    'S', // 文
    'SINV', // 倒置文
    'SQ', // 疑問文
    'SBARQ', // Wh疑問文
    'FRAG', // 断片
    
    // 11. 特殊タグ
    'ROOT', // ルート
    'X', // 不明または分類不能
    'INTJ', // 間投句
    'PRN', // 括弧内の表現
    
    // 12. 句読点
    // '.', // ピリオド
    ',', // カンマ
    ':', // コロン
    '-LRB-', // 左括弧
    '-RRB-', // 右括弧
    
    // 謎のタグ
    '-R-',
    '-L-',
    'P',
    'G',
    'P',
    'UCPNML',
    'WHADVP',
    'WHNP',
    
    
    'S',    // 文
    // 一時移動
    'ADVP', // 副詞句（特に複数の修飾語がある場合）
    'VP',   // 動詞句
    'ADJP', // 形容詞句（特に複数の修飾語がある場合）
    'CC',    // 等位接続詞
    'NP',   // 名詞句
    'IN', // 前置詞/従属接続詞
];

// 改行を挿入するタグ
$breakLineAfter = [
    'SBAR', // 従属節
    '))(, ,)',
];

// 改行とインデントを挿入するタグ
$breakLineAndIndent = [
    'PP',   // 長い前置詞句
];

// 解析結果を処理する関数
function processParseResults($parse_results, $breakLineAfter, $breakLineAndIndent, $tags) {
    $results = []; // 解析結果の文字列を格納する配列(改行の数 + 1要素)
    for ($i = 0; $i < count($parse_results); $i++) { // 解析結果の格納
        for ($j = 0; $j < count($parse_results[$i]["penn"]["children"]); $j++) {
            $result = setTree($parse_results[$i]["penn"]["children"][$j]); // 結果を格納

            // $breakLineAfterの記号で改行を挿入し、その後空文字に置換
            // foreach ($breakLineAfter as $symbol) {
            //     $pattern = '/(?<=\(|\)|\s|^)' . preg_quote($symbol, '/') . '(?=\(|\)|\s|$)/';
            //     $result = preg_replace($pattern, '<br>', $result);
            // }
            // 改行とインデントを挿入するタグ
            // foreach ($breakLineAndIndent as $symbol) {
            //     $pattern = '/(?<=\(|\)|\s|^)' . preg_quote($symbol, '/') . '(?=\(|\)|\s|$)/';
            //     $result = preg_replace($pattern, '<br>&nbsp;&nbsp;&nbsp;&nbsp;', $result);
            // }

            // $tagsの記号を空文字に置換
            // foreach ($tags as $tag) {
            //     $pattern = '/(?<=\(|\)|\s|^)' . preg_quote($tag, '/') . '(?=\(|\)|\s|$)/';
            //     $result = preg_replace($pattern, '', $result);
            // }

            // (や)を空文字に置き換え
            // $result = str_replace(['(', ')'], '', $result);

            // 文末の句読点を空文字に置き換え
            // $result = str_replace('. .', '.', $result);

            $results[$i] = $result;
        }
    }
    return $results; // 結果を返す
}

try {
    // 標準設定では約70単語程度が処理の目安
    // トークン数で数えて通常は40-80トークンが安全な範囲
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $dbh = null;

    // 英文解析
    $text_input = $_POST['text_input']; // POSTから受け取る
    $text_list = preg_split('/\r\n|\r|\n/', $text_input); // 改行で分割し配列に格納
    $parse_results = $parser->parseSentences($text_list); // 解析を実行

    // 関数を呼び出して解析結果を処理
    $results = processParseResults($parse_results, $breakLineAfter, $breakLineAndIndent, $tags);
} catch (PDOException $e) {
    header('Location: login.php?banner=9', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>構文解析</title>
        <meta name = "description" content = "構文解析結果">
        <meta name = "viewport" content = "width=device-width">
        <link href = "../common/css/header.css" rel = "stylesheet">
        <link href = "../common/css/body.css" rel = "stylesheet">
        <link href = "../common/css/generate.css" rel = "stylesheet">
        <link rel = "apple-touch-icon" sizes = "180x180" href = "../common/icons/apple-touch-icon.png">
		<link rel = "manifest" href = "../common/icons/manifest.json">
		<link rel = "icon" href = "../common/icons/favicon.ico" type = "image/x-icon">
		<link rel = "icon" type = "image/png" sizes = "16x16" href = "../common/icons/favicon-16x16.png">
		<link rel = "icon" type = "image/png" sizes = "32x32" href = "../common/icons/favicon-32x32.png">
		<link rel = "icon" type = "image/png" sizes = "48x48" href = "../common/icons/favicon-48x48.png">
		<meta name="theme-color" content="#ffffff">
        <script src = "../common/js/toggle-menu.js"></script>
        <script src = "../common/js/toggle-structure.js"></script>
        <script src = "../common/js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-block">
                <p class = "main-block-title">解析結果</p>
                <button class = "button-howto">
                    <p>構文規則</p>
                </button>
                <div class = "block-howto">
                    <ul>
                        <li>主語　：S</li>
                        <li>動詞　：V</li>
                        <li>目的語：O</li>
                        <li>補語　：C</li>
                        <li>形容詞：( )</li>
                        <li>副詞　：[ ]</li>
                    </ul>
                </div>

                <!-- 英文解析 結果 -->
                <!-- <div class="result-content">
                    <h2>解析結果の詳細</h2>
                    <pre>
                        <?php // echo htmlspecialchars(print_r($temp, true)); ?>
                    </pre>
                </div> -->
                <div style="margin-top: 20px; margin-bottom: 20px; max-width: 80%;">
                    <?php foreach ($results as $i => $r) { ?>
                        <div style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;">
                            <!-- <p>
                                <?php // echo $text_list[$i] ?>
                            </p> -->
                            <p style = "line-height: 1.5; color: #333;"><?php echo $r ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </main>
    </body>
</html>
