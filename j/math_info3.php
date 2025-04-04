<?php
function make3($level) {
    if ($level == '1') {
        for (;;) {
            $num = [random_int(1, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            if (($a + $b) % 2 == 0 && ($a - $b) % 2 == 0) {
                $answer = [intdiv(($a + $b), 2), intdiv(($a - $b), 2)];
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
                if ($sign[1] == '+') {
                    $result_1 = '
                        <mn>' . (string)$num[1] . '</mn>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $sign[1] . '</mo>
                        <mn>' . (string)$num[1] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">
                        <mo>{</mo>
                        <mtable columnalign="left">
                            <mtr>
                                <mtd>
                                    <mi>x</mi>
                                    <mo>+</mo>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_0
                                . '</mtd>
                            </mtr>
                            <mtr>
                                <mtd>
                                    <mi>x</mi>
                                    <mo>-</mo>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_1
                                . '</mtd>
                            </mtr>
                        </mtable>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '2') {
        for (;;) {
            $num = [random_int(1, 9), random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            if ($b != -1 && ($a * $b + $c) % ($b + 1) == 0 && ($c - $a) % ($b + 1) == 0) {
                $answer = [intdiv(($a * $b + $c), ($b + 1)), intdiv(($c - $a), ($b + 1))];
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
                    <math display = "block">
                        <mo>{</mo>
                        <mtable columnalign="left">
                            <mtr>
                                <mtd>
                                    <mi>x</mi>
                                    <mo>-</mo>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_0
                                . '</mtd>
                            </mtr>
                            <mtr>
                                <mtd>
                                    <mi>x</mi>
                                    <mo>' . $sign[1] . '</mo>
                                    <mn>' . (string)$num[1] . '</mn>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_1
                                . '</mtd>
                            </mtr>
                        </mtable>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '3') {
        for (;;) {
            $num = [random_int(1, 9), random_int(2, 9), random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            $d = $num[3] * $sign2[3];
            if ($b + $c != 0 && ($d + $a * $c) % ($b + $c) == 0 && ($d - $a * $b) % ($b + $c) == 0) {
                $answer = [intdiv(($d + $a * $c), ($b + $c)), intdiv(($d - $a * $b), ($b + $c))];
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
                if ($sign[1] == '+') {
                    $result_1 = '
                        <mn>' . (string)$num[1] . '</mn>
                    ';
                } else {
                    $result_1 = '
                        <mo>' . $sign[1] . '</mo>
                        <mn>' . (string)$num[1] . '</mn>
                    ';
                }
                if ($sign[3] == '+') {
                    $result_2 = '
                        <mn>' . (string)$num[3] . '</mn>
                    ';
                } else {
                    $result_2 = '
                        <mo>' . $sign[3] . '</mo>
                        <mn>' . (string)$num[3] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">
                        <mo>{</mo>
                        <mtable columnalign="left">
                            <mtr>
                                <mtd>
                                    <mi>x</mi>
                                    <mo>-</mo>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_0
                                . '</mtd>
                            </mtr>
                            <mtr>
                                <mtd>' .
                                    $result_1
                                    . '<mi>x</mi>
                                    <mo>' . $sign[2] . '</mo>
                                    <mn>' . (string)$num[2] . '</mn>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_2
                                . '</mtd>
                            </mtr>
                        </mtable>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '4') {
        for (;;) {
            $num = [random_int(2, 9), random_int(2, 9), random_int(1, 9), random_int(2, 9), random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign(), get_sign(), get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3]), get_sign2($sign[4]), get_sign2($sign[5])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            $d = $num[3] * $sign2[3];
            $e = $num[4] * $sign2[4];
            $f = $num[5] * $sign2[5];
            if ($a * $e != $b * $d && ($c * $e - $b * $f) % ($a * $e - $b * $d) == 0 && ($c * $d - $a * $f) % ($b * $d - $a * $e) == 0) {
                $answer = [intdiv(($c * $e - $b * $f), ($a * $e - $b * $d)), intdiv(($c * $d - $a * $f), ($b * $d - $a * $e))];
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
                if ($sign[3] == '+') {
                    $result_2 = '
                        <mn>' . (string)$num[3] . '</mn>
                    ';
                } else {
                    $result_2 = '
                        <mo>' . $sign[3] . '</mo>
                        <mn>' . (string)$num[3] . '</mn>
                    ';
                }
                if ($sign[5] == '+') {
                    $result_3 = '
                        <mn>' . (string)$num[5] . '</mn>
                    ';
                } else {
                    $result_3 = '
                        <mo>' . $sign[5] . '</mo>
                        <mn>' . (string)$num[5] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">
                        <mo>{</mo>
                        <mtable columnalign="left">
                            <mtr>
                                <mtd>' .
                                    $result_0
                                    . '<mi>x</mi>
                                    <mo>' . $sign[1] . '</mo>
                                    <mn>' . (string)$num[1] . '</mn>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_1
                                . '</mtd>
                            </mtr>
                            <mtr>
                                <mtd>' .
                                    $result_2
                                    . '<mi>x</mi>
                                    <mo>' . $sign[4] . '</mo>
                                    <mn>' . (string)$num[4] . '</mn>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_3
                                . '</mtd>
                            </mtr>
                        </mtable>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '5') {
        for (;;) {
            $num = [random_int(2, 99), random_int(2, 99), random_int(1, 99), random_int(2, 99), random_int(2, 99), random_int(1, 99)];
            $sign = [get_sign(), get_sign(), get_sign(), get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3]), get_sign2($sign[4]), get_sign2($sign[5])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            $d = $num[3] * $sign2[3];
            $e = $num[4] * $sign2[4];
            $f = $num[5] * $sign2[5];
            if ($a * $e != $b * $d && ($c * $e - $b * $f) % ($a * $e - $b * $d) == 0 && ($c * $d - $a * $f) % ($b * $d - $a * $e) == 0) {
                $answer = [intdiv(($c * $e - $b * $f), ($a * $e - $b * $d)), intdiv(($c * $d - $a * $f), ($b * $d - $a * $e))];
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
                if ($sign[3] == '+') {
                    $result_2 = '
                        <mn>' . (string)$num[3] . '</mn>
                    ';
                } else {
                    $result_2 = '
                        <mo>' . $sign[3] . '</mo>
                        <mn>' . (string)$num[3] . '</mn>
                    ';
                }
                if ($sign[5] == '+') {
                    $result_3 = '
                        <mn>' . (string)$num[5] . '</mn>
                    ';
                } else {
                    $result_3 = '
                        <mo>' . $sign[5] . '</mo>
                        <mn>' . (string)$num[5] . '</mn>
                    ';
                }
                $result = '
                    <div>
                    <math display = "block">
                        <mo>{</mo>
                        <mtable columnalign="left">
                            <mtr>
                                <mtd>' .
                                    $result_0
                                    . '<mi>x</mi>
                                    <mo>' . $sign[1] . '</mo>
                                    <mn>' . (string)$num[1] . '</mn>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_1
                                . '</mtd>
                            </mtr>
                            <mtr>
                                <mtd>' .
                                    $result_2
                                    . '<mi>x</mi>
                                    <mo>' . $sign[4] . '</mo>
                                    <mn>' . (string)$num[4] . '</mn>
                                    <mi>y</mi>
                                    <mo>=</mo>' .
                                    $result_3
                                . '</mtd>
                            </mtr>
                        </mtable>
                    </math>
                    </div>
                ';
                break;
            }
        }
    }
    return [$result, $answer];
}

function write3($level, $answer) {
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
                <mi>　y</mi>
                <mo>=</mo>
                <mrow class = "input_box_block box_block_1">
                    <mn class = "input_box_display box_display_1">0</mn>
                    <mn class = "input_box_set box_set_1">00</mn>
                    <mo class = "input_box_sign box_sign_1"></mo>
                    <mn class = "input_box box_1"></mn>
                    <button class = "input_box_button box_button_1" type = "button">000</button>
                </mrow>
            </mrow>
        </math>
        </div>
    ';
    return $result;
}

function feedback3($level, $answer) {
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
                <mi>　y</mi>
                <mo>=</mo>
                <mrow class = "input_box_block box_block_1">
                    <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                    <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                </mrow>
            </mrow>
        </math>
        </div>
    ';
    return $result;
}
