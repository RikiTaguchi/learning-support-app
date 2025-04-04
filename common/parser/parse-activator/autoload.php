<?php
// autoload mimicks https://github.com/auraphp
spl_autoload_register(function ($class) {

    // the package namespace
    $ns = 'StanfordNLP';

    // what prefixes should be recognized?
    $prefixes = array(
        "{$ns}\\" => array(
            // __DIR__ . '/src/' . $ns,
            '../common/parser/src/' . $ns,
        ),
    );

    // go through the prefixes
    foreach ($prefixes as $prefix => $dirs) {

        // does the requested class match the namespace prefix?
        $prefix_len = strlen($prefix);
        if (substr($class, 0, $prefix_len) !== $prefix) {
            continue;
        }

        // strip the prefix off the class
        $class = substr($class, $prefix_len);

        // a partial filename
        $part = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        // go through the directories to find classes
        foreach ($dirs as $dir) {
            $dir = str_replace('/', DIRECTORY_SEPARATOR, $dir);
            $file = $dir . DIRECTORY_SEPARATOR . $part;
            if (is_readable($file)) {
                require $file;
                return;
            }
        }
    }
});

// パスの指定
$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "stanford-parser";
$parser = new \StanfordNLP\Parser(
    $path . DIRECTORY_SEPARATOR . "stanford-parser.jar",
    $path . DIRECTORY_SEPARATOR . "stanford-parser-4.2.0-models.jar"
);

// 構文解析結果を１つの文字列に結合する関数
function setTree ($target) {
    if (count($target["children"]) == 0) {
        $answer = "(" . $target["parent"] . ")";
    } else {
        $answer = "(" . $target["parent"];
        for ($k = 0; $k < count($target["children"]); $k++) {
            $answer .= setTree($target["children"][$k]); // 再帰させる
        }
        $answer .= ")";
    }
    return $answer;
}
