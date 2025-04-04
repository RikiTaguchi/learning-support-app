<?php
function make1($level) {
    if ($level == '1') {
        $num = [random_int(0, 9), random_int(0, 9)];
        $sign = [get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
        $answer = [$num[0] * $sign2[0] + $num[1] * $sign2[1]];
        if ($sign[0] == '+') {
            $result = '
                <div>
                <math display = "block">
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math display = "block">
                    <mo>' . $sign[0] . '</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                </math>
                </div>
            ';
        }
    } else if ($level == '2') {
        $num = [random_int(0, 9), random_int(0, 9), random_int(0, 9)];
        $sign = [get_sign(), get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
        $answer = [$num[0] * $sign2[0] + $num[1] * $sign2[1] + $num[2] * $sign2[2]];
        if ($sign[0] == '+') {
            $result = '
                <div>
                <math display = "block">
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math display = "block">
                    <mo>' . $sign[0] . '</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                </math>
                </div>
            ';
        }
    } else if ($level == '3') {
        $num = [random_int(0, 99), random_int(0, 99), random_int(0, 99)];
        $sign = [get_sign(), get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
        $answer = [$num[0] * $sign2[0] + $num[1] * $sign2[1] + $num[2] * $sign2[2]];
        if ($sign[0] == '+') {
            $result = '
                <div>
                <math display = "block">
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math display = "block">
                    <mo>' . $sign[0] . '</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                </math>
                </div>
            ';
        }
    } else if ($level == '4') {
        $num = [random_int(0, 99), random_int(0, 99), random_int(0, 99), random_int(0, 99)];
        $sign = [get_sign(), get_sign(), get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3])];
        $answer = [$num[0] * $sign2[0] + $num[1] * $sign2[1] + $num[2] * $sign2[2] + $num[3] * $sign2[3]];
        if ($sign[0] == '+') {
            $result = '
                <div>
                <math display = "block">
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                    <mo>' . $sign[3] . '</mo>
                    <mn>' . (string)$num[3] . '</mn>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math display = "block">
                    <mo>' . $sign[0] . '</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                    <mo>' . $sign[3] . '</mo>
                    <mn>' . (string)$num[3] . '</mn>
                </math>
                </div>
            ';
        }
    } else if ($level == '5') {
        $num = [random_int(0, 999), random_int(0, 999), random_int(0, 999), random_int(0, 999), random_int(0, 999)];
        $sign = [get_sign(), get_sign(), get_sign(), get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3]), get_sign2($sign[4])];
        $answer = [$num[0] * $sign2[0] + $num[1] * $sign2[1] + $num[2] * $sign2[2] + $num[3] * $sign2[3] + $num[4] * $sign2[4]];
        if ($sign[0] == '+') {
            $result = '
                <div>
                <math display = "block">
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                    <mo>' . $sign[3] . '</mo>
                    <mn>' . (string)$num[3] . '</mn>
                    <mo>' . $sign[4] . '</mo>
                    <mn>' . (string)$num[4] . '</mn>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math display = "block">
                    <mo>' . $sign[0] . '</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                    <mo>' . $sign[3] . '</mo>
                    <mn>' . (string)$num[3] . '</mn>
                    <mo>' . $sign[4] . '</mo>
                    <mn>' . (string)$num[4] . '</mn>
                </math>
                </div>
            ';
        }
    }
    return [$result, $answer];
}

function write1($level, $answer) {
    $result = '
        <div>
        <math class = "input_area_inner" display = "block">
            <mrow class = "input_area_subblock">
                <mo>=</mo>
                <mrow class = "input_box_block box_block_0">
                    <mn class = "input_box_display box_display_0">0</mn>
                    <mn class = "input_box_set box_set_0">00</mn>
                    <mo class = "input_box_sign box_sign_0"></mo>
                    <mn class = "input_box box_0"></mn>
                    <button class = "input_box_button box_button_0" type = "button">000</button>
                </mrow>
            </mrow>
        </math>
        </div>
    ';
    return $result;
}

function feedback1($level, $answer) {
    $answer_sign = [];
    for ($i = 0; $i < count($answer); $i += 1) {
        if (strval($answer[$i]) < 0) {
            $answer_sign[] = '-';
        } else {
            $answer_sign[] = '';
        }
    }
    $result = '
        <div>
        <math class = "input_area_inner" display = "block">
            <mrow class = "input_area_subblock">
                <mo>=</mo>
                <mrow class = "input_box_block box_block_0">
                    <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                    <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                </mrow>
            </mrow>
        </math>
        </div>
    ';
    return $result;
}
