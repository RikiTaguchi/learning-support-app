<?php
function set_question($type, $level) {
    if ($type == 'n' || $level == 'n') {
        if ($type == 'n') {
            header('Location: error.php?type=38', true, 307);
            exit;
        } else if ($level == 'n') {
            header('Location: error.php?type=39', true, 307);
            exit;
        } else {
            header('Location: error.php?type=12', true, 307);
            exit;
        }
    } else if ($type == '1') {
        $title = '正負の数';
        $data = make1($level);
        $question = $data[0];
        $answer = $data[1];
        $input = write1($level, $answer);
        $feedback_data = feedback1($level, $answer);
    } else if ($type == '2') {
        $title = '１次方程式';
        $data = make2($level);
        $question = $data[0];
        $answer = $data[1];
        $input = write2($level, $answer);
        $feedback_data = feedback2($level, $answer);
    } else if ($type == '3') {
        $title = '連立方程式';
        $data = make3($level);
        $question = $data[0];
        $answer = $data[1];
        $input = write3($level, $answer);
        $feedback_data = feedback3($level, $answer);
    } else if ($type == '4') {
        $title = '展開';
        $data = make4($level);
        $question = $data[0];
        $answer = $data[1];
        $input = write4($level, $answer);
        $feedback_data = feedback4($level, $answer);
    } else if ($type == '5') {
        $title = '因数分解';
        $data = make5($level);
        $question = $data[0];
        $answer = $data[1];
        $input = write5($level, $answer);
        $feedback_data = feedback5($level, $answer);
    } else if ($type == '6') {
        $title = '平方根';
        $data = make6($level);
        $question = $data[0];
        $answer = $data[1];
        $input = write6($level, $answer);
        $feedback_data = feedback6($level, $answer);
    } else {
        header('Location: error.php?type=12', true, 307);
        exit;
    }
    return [$title, $question, $input, $answer, $feedback_data];
}

function get_sign() {
    if (random_int(0, 1) == 0) {
        return '+';
    } else {
        return '-';
    }
}

function get_sign2($info_sign) {
    if ($info_sign == '+') {
        return 1;
    } else {
        return -1;
    }
}

function get_gcd($num1, $num2) {
    $gcd = 1;
    $num1_list = [];
    $num2_list = [];

    for ($i = $num1; $i >= 1; $i -= 1) {
        if ($num1 % $i == 0) {
            $num1_list[] = $i;
        }
    }
    for ($i = $num2; $i >= 1; $i -= 1) {
        if ($num2 % $i == 0) {
            $num2_list[] = $i;
        }
    }

    for ($i = count($num1_list) - 1; $i >= 0; $i -= 1) {
        for ($j = count($num2_list) - 1; $j >= 0; $j -= 1) {
            if ($num1_list[$i] == $num2_list[$j]) {
                $gcd = $num1_list[$i];
                break;
            }
        }
    }

    return $gcd;
}

function check_sqrt($num) {
    for ($i = 2; $i < $num; $i += 1) {
        if ($num % $i == 0) {
            if (intdiv($num, $i) % $i == 0) {
                $check = false;
                break;
            } else {
                $check = true;
            }
        } else {
            $check = true;
        }
    }
    return $check;
}
