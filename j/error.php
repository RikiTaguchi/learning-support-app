<?php
$type = $_GET['type'];
if ($type == '3' || $type == '9' || $type == '12') {
    $url = 'Location: index.php?banner=' . $type;
} else if ($type == '0' || $type == '1' || $type == '2' || $type == '6' || $type == '13' || $type == '14' || $type == '15' || $type == '41') {
    $url = 'Location: login.php?banner=' . $type;
} else if ($type == '7') {
    $url = 'Location: detail.php?banner=' . $type;
} else if ($type == '10') {
    $url = 'Location: make_account.php?banner=' . $type;
} else if ($type == '11') {
    $url = 'Location: form4.php?banner=' . $type;
} else if ($type == '4' || $type == '5') {
    $url = 'Location: info_account.php?banner=' . $type;
} else if ($type == '16') {
    $url = 'Location: form.php?banner=' . $type;
} else if ($type == '17') {
    $url = 'Location: form.php?banner=' . $type;
} else if ($type == '18') {
    $url = 'Location: form2.php?banner=' . $type;
} else if ($type == '19') {
    $url = 'Location: form2.php?banner=' . $type;
} else if ($type == '20') {
    $url = 'Location: form3.php?banner=' . $type;
} else if ($type == '22' || $type == '23' || $type == '24' || $type == '27' || $type == '28' || $type == '32') {
    $url = 'Location: director/login_director.php?banner=' . $type;
} else if ($type == '26') {
    $url = 'Location: director/make_director.php?banner=' . $type;
} else if ($type == '30' || $type == '31') {
    $url = 'Location: director/info_director.php?banner=' . $type;
} else if ($type == '36' || $type == '37') {
    $url = 'Location: form9.php?banner=' . $type;
} else if ($type == '38') {
    $url = 'Location: form10.php?banner=' . $type;
} else if ($type == '39') {
    $url = 'Location: form10.php?banner=' . $type;
} else if ($type == '40') {
    $url = 'Location: form10.php?banner=' . $type;
} else {
    $url = 'Location: login.php?banner=13';
}
header($url, true, 307);
exit;
