<?php
function make2($level) {
    if ($level == '1') {
        $num = [1, random_int(1, 9)];
        $sign = [get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
        $answer = [$num[0] * $sign2[0] * (-1) * $num[1] * $sign2[1]];
        if ($sign[0] == '+') {
            $result = '
                <div>
                <math display = "block">
                    <mi>x</mi>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>=</mo>
                    <mn>0</mn>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math display = "block">
                    <mo>' . $sign[0] . '</mo>
                    <mi>x</mi>
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>=</mo>
                    <mn>0</mn>
                </math>
                </div>
            ';
        }
    } else if ($level == '2') {
        for (;;) {
            $num = [random_int(2, 9), random_int(1, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
            if (($num[2] * $sign2[2] - $num[1] * $sign2[1]) % ($num[0] * $sign2[0]) == 0) {
                $answer = [intdiv(($num[2] * $sign2[2] - $num[1] * $sign2[1]), ($num[0] * $sign2[0]))];
                if ($sign[0] == '+') {
                    $result_0 = '
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                } else {
                    $result_0 = '
                        <mo>' . $sign[0] . '</mo>
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                }
                if ($sign[2] == '+') {
                    $result_1 = '
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $sign[2] . '</mo>
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">' .
                        $result_0
                        . '<mi>x</mi>
                        <mo>' . $sign[1] . '</mo>
                        <mn>' . (string)$num[1] . '</mn>
                        <mo>=</mo>' .
                        $result_1
                    . '</math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '3') {
        for (;;) {
            $num = [random_int(2, 9), random_int(1, 9), random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3])];
            if (($num[0] * $sign2[0]) != ($num[2] * $sign2[2]) && ($num[3] * $sign2[3] - $num[1] * $sign2[1]) % ($num[0] * $sign2[0] - $num[2] * $sign2[2]) == 0) {
                $answer = [intdiv(($num[3] * $sign2[3] - $num[1] * $sign2[1]), ($num[0] * $sign2[0] - $num[2] * $sign2[2]))];
                if ($sign[0] == '+') {
                    $result_0 = '
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                } else {
                    $result_0 = '
                        <mo>' . $sign[0] . '</mo>
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                }
                if ($sign[2] == '+') {
                    $result_1 = '
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $sign[2] . '</mo>
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">' .
                        $result_0
                        . '<mi>x</mi>
                        <mo>' . $sign[1] . '</mo>
                        <mn>' . (string)$num[1] . '</mn>
                        <mo>=</mo>' .
                        $result_1
                        . '<mi>x</mi>
                        <mo>' . $sign[3] . '</mo>
                        <mn>' . (string)$num[3] . '</mn>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '4') {
        for (;;) {
            $num = [random_int(2, 99), random_int(1, 99), random_int(2, 99), random_int(1, 99)];
            $sign = [get_sign(), get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3])];
            if (($num[0] * $sign2[0]) != ($num[2] * $sign2[2]) && ($num[3] * $sign2[3] - $num[1] * $sign2[1]) % ($num[0] * $sign2[0] - $num[2] * $sign2[2]) == 0) {
                $answer = [intdiv(($num[3] * $sign2[3] - $num[1] * $sign2[1]), ($num[0] * $sign2[0] - $num[2] * $sign2[2]))];
                if ($sign[0] == '+') {
                    $result_0 = '
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                } else {
                    $result_0 = '
                        <mo>' . $sign[0] . '</mo>
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                }
                if ($sign[2] == '+') {
                    $result_1 = '
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $sign[2] . '</mo>
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">' .
                        $result_0
                        . '<mi>x</mi>
                        <mo>' . $sign[1] . '</mo>
                        <mn>' . (string)$num[1] . '</mn>
                        <mo>=</mo>' .
                        $result_1
                        . '<mi>x</mi>
                        <mo>' . $sign[3] . '</mo>
                        <mn>' . (string)$num[3] . '</mn>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '5') {
        for (;;) {
            $num = [random_int(2, 999), random_int(1, 999), random_int(2, 999), random_int(1, 999)];
            $sign = [get_sign(), get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3])];
            if (($num[0] * $sign2[0]) != ($num[2] * $sign2[2]) && ($num[3] * $sign2[3] - $num[1] * $sign2[1]) % ($num[0] * $sign2[0] - $num[2] * $sign2[2]) == 0) {
                $answer = [intdiv(($num[3] * $sign2[3] - $num[1] * $sign2[1]), ($num[0] * $sign2[0] - $num[2] * $sign2[2]))];
                if ($sign[0] == '+') {
                    $result_0 = '
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                } else {
                    $result_0 = '
                        <mo>' . $sign[0] . '</mo>
                        <mn>' . (string)$num[0] . '</mn>
                    ';
                }
                if ($sign[2] == '+') {
                    $result_1 = '
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $sign[2] . '</mo>
                        <mn>' . (string)$num[2] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">' .
                        $result_0
                        . '<mi>x</mi>
                        <mo>' . $sign[1] . '</mo>
                        <mn>' . (string)$num[1] . '</mn>
                        <mo>=</mo>' .
                        $result_1
                        . '<mi>x</mi>
                        <mo>' . $sign[3] . '</mo>
                        <mn>' . (string)$num[3] . '</mn>
                    </math>
                    </div>
                ';
                break;
            }
        }
    }
    return [$result, $answer];
}

function write2($level, $answer) {
    $result = '
        <div>
        <math class = "input_area_inner" display = "block">
            <mrow class = "input_area_subblock">
                <mi>x</mi>
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

function feedback2($level, $answer) {
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
                <mi>x</mi>
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
