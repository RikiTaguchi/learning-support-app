<?php
function make6($level) {
    if ($level == '1') {
        for (;;) {
            $num = [random_int(2, 9), random_int(2, 9)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            if ($a * $a != $b * $b) {
                $answer = [$a + $b];
                if ($sign[0] == '-') {
                    $info_join_1 = '-';
                } else {
                    $info_join_1 = '';
                }
                if ($sign[1] == '-') {
                    $info_join_2 = '-';
                } else {
                    $info_join_2 = '+';
                }
                $result = '
                    <div>
                    <math display = "block">
                        <mo>' . $info_join_1 . '</mo>
                        <msqrt>
                            <mn>' . (string)($a * $a) . '</mn>
                        </msqrt>
                        <mo>' . $info_join_2 . '</mo>
                        <msqrt>
                            <mn>' . (string)($b * $b) . '</mn>
                        </msqrt>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '2') {
        for (;;) {
            $num = [random_int(2, 9), random_int(2, 9)];
            $sign = ['+', '+'];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            if (check_sqrt($b) && $a * $a * $b < 100) {
                $answer = [$a, $b];
                $result = '
                    <div>
                    <math display = "block">
                        <msqrt>
                            <mn>' . (string)($a * $a * $b) . '</mn>
                        </msqrt>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '3') {
        for (;;) {
            $num = [random_int(2, 9), random_int(2, 9), random_int(2, 9)];
            $sign = [get_sign(), get_sign(), '+'];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            if (check_sqrt($c) && ($a * $a != $b * $b) && ($a * $a * $c < 100) && ($b * $b * $c < 100) && abs($a + $b) != 1) {
                $answer = [$a + $b, $c];
                if ($a < 0) {
                    $info_join_1 = '-';
                } else {
                    $info_join_1 = '';
                }
                if ($b < 0) {
                    $info_join_2 = '-';
                } else {
                    $info_join_2 = '+';
                }
                $result = '
                    <div>
                    <math display = "block">
                        <mo>' . $info_join_1 . '</mo>
                        <msqrt>
                            <mn>' . (string)($a * $a * $c) . '</mn>
                        </msqrt>
                        <mo>' . $info_join_2 . '</mo>
                        <msqrt>
                            <mn>' . (string)($b * $b * $c) . '</mn>
                        </msqrt>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '4') {
        for (;;) {
            $num = [random_int(2, 9), random_int(2, 9), random_int(2, 9)];
            $sign = [get_sign(), get_sign(), '+'];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            if (check_sqrt($c) && ($a * $a != $b * $b) && ($a * $a * $c < 100) && ($b * $b * $c < 100) && abs($a + $b) != 1) {
                $answer = [$a + $b, $c];
                $style = [random_int(0, 1), random_int(0, 1)];
                if ($a < 0) {
                    $info_join_1 = '-';
                } else {
                    $info_join_1 = '';
                }
                if ($b < 0) {
                    $info_join_2 = '-';
                } else {
                    $info_join_2 = '+';
                }
                if ($style[0] == 0) {
                    $result_0 = '
                        <mo>' . $info_join_1 . '</mo>
                        <msqrt>
                            <mn>' . (string)($a * $a * $c) . '</mn>
                        </msqrt>
                    ';
                } else {
                    $result_0 = '
                        <mo>' . $info_join_1 . '</mo>
                        <mfrac>
                            <mn>' . (string)abs(($a * $c)) . '</mn>
                            <msqrt>
                                <mn>' . (string)$c . '</mn>
                            </msqrt>
                        </mfrac>
                    ';
                }
                if ($style[1] == 0) {
                    $result_1 = '
                        <mo>' . $info_join_2 . '</mo>
                        <msqrt>
                            <mn>' . (string)($b * $b * $c) . '</mn>
                        </msqrt>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $info_join_2 . '</mo>
                        <mfrac>
                            <mn>' . (string)abs(($b * $c)) . '</mn>
                            <msqrt>
                                <mn>' . (string)$c . '</mn>
                            </msqrt>
                        </mfrac>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">'. 
                        $result_0 . 
                        $result_1 .
                    '</math>
                    </div>
                ';
                break;
            }

        }
    } else if ($level == '5') {
        for (;;) {
            $num = [random_int(2, 99), random_int(2, 99), random_int(2, 99)];
            $sign = [get_sign(), get_sign(), '+'];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            if (check_sqrt($c) && ($a * $a != $b * $b) && ($a * $a * $c < 1000) && ($b * $b * $c < 1000) && abs($a + $b) != 1) {
                $answer = [$a + $b, $c];
                $style = [random_int(0, 1), random_int(0, 1)];
                if ($a < 0) {
                    $info_join_1 = '-';
                } else {
                    $info_join_1 = '';
                }
                if ($b < 0) {
                    $info_join_2 = '-';
                } else {
                    $info_join_2 = '+';
                }
                if ($style[0] == 0) {
                    $result_0 = '
                        <mo>' . $info_join_1 . '</mo>
                        <msqrt>
                            <mn>' . (string)($a * $a * $c) . '</mn>
                        </msqrt>
                    ';
                } else {
                    $result_0 = '
                        <mo>' . $info_join_1 . '</mo>
                        <mfrac>
                            <mn>' . (string)abs(($a * $c)) . '</mn>
                            <msqrt>
                                <mn>' . (string)$c . '</mn>
                            </msqrt>
                        </mfrac>
                    ';
                }
                if ($style[1] == 0) {
                    $result_1 = '
                        <mo>' . $info_join_2 . '</mo>
                        <msqrt>
                            <mn>' . (string)($b * $b * $c) . '</mn>
                        </msqrt>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $info_join_2 . '</mo>
                        <mfrac>
                            <mn>' . (string)abs(($b * $c)) . '</mn>
                            <msqrt>
                                <mn>' . (string)$c . '</mn>
                            </msqrt>
                        </mfrac>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">'. 
                        $result_0 . 
                        $result_1 .
                    '</math>
                    </div>
                ';
                break;
            }

        }
    }
    return [$result, $answer];
}

function write6($level, $answer) {
    if ($level == '1') {
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
    } else {
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
                    <msqrt>
                        <mrow class = "input_area_subblock">
                            <mrow class = "input_box_block box_block_1">
                                <mn class = "input_box_display box_display_1">0</mn>
                                <mn class = "input_box_set box_set_1">00</mn>
                                <mo class = "input_box_sign box_sign_1"></mo>
                                <mn class = "input_box box_1"></mn>
                                <button class = "input_box_button box_button_1" type = "button">000</button>
                            </mrow>
                        </mrow>
                    </msqrt>
                </mrow>
            </math>
            </div>
        ';
    }
    return $result;
}

function feedback6($level, $answer) {
    $answer_sign = [];
    for ($i = 0; $i < count($answer); $i += 1) {
        if (strval($answer[$i]) < 0) {
            $answer_sign[] = '-';
        } else {
            $answer_sign[] = '';
        }
    }
    if ($level == '1') {
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
    } else {
        $result = '
            <div>
            <math class = "input_area_inner" display = "block">
                <mrow class = "input_area_subblock">
                    <mo>=</mo>
                    <mrow class = "input_box_block box_block_0">
                        <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                        <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                    </mrow>
                    <msqrt>
                        <mrow class = "input_area_subblock">
                            <mrow class = "input_box_block box_block_1">
                                <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                                <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                            </mrow>
                        </mrow>
                    </msqrt>
                </mrow>
            </math>
            </div>
        ';
    }
    return $result;
}
