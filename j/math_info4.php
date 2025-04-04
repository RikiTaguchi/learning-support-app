<?php
function make4($level) {
    if ($level == '1') {
        $num = [random_int(2, 9), random_int(2, 9), random_int(1, 9)];
        $sign = [get_sign(), get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
        $a = $num[0] * $sign2[0];
        $b = $num[1] * $sign2[1];
        $c = $num[2] * $sign2[2];
        $style = random_int(0, 1);
        if ($style == 0) {
            $num = [random_int(2, 9), random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            $answer = [$a * $b, $a * $c];
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
                <math display = "block">' .
                    $result_0
                    . '<mo>(</mo>' .
                    $result_1
                    . '<mi>x</mi>
                    <mo>' . $sign[2] . '</mo>
                    <mn>' . (string)$num[2] . '</mn>
                    <mo>)</mo>
                </math>
                </div>
            ';
        } else {
            for (;;) {
                $num = [random_int(2, 9), random_int(2, 99), random_int(2, 99)];
                $sign = [get_sign(), get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                $c = $num[2] * $sign2[2];
                if ($b % $a == 0 && $c % $a == 0) {
                    $answer = [intdiv($b, $a), intdiv($c, $a)];
                    if ($sign[1] == '+') {
                        $result_0 = '
                            <mn>' . (string)$num[1] . '</mn>
                        ';
                    } else {
                        $result_0 = '
                            <mo>' . $sign[1] . '</mo>
                            <mn>' . (string)$num[1] . '</mn>
                        ';
                    }
                    if ($sign[0] == '+') {
                        $result = '
                            <div>
                            <math display = "block">
                                <mfrac>
                                    <mn>1</mn>
                                    <mrow>
                                        <mn>' . (string)$num[0] . '</mn>
                                    </mrow>
                                </mfrac>
                                <mo>(</mo>' .
                                $result_0
                                . '<mi>x</mi>
                                <mo>' . $sign[2] . '</mo>
                                <mn>' . (string)$num[2] . '</mn>
                                <mo>)</mo>
                            </math>
                            </div>
                        ';
                    } else {
                        $result = '
                            <div>
                            <math display = "block">
                                <mo>' . $sign[0] . '</mo>
                                <mfrac>
                                    <mn>1</mn>
                                    <mrow>
                                        <mn>' . (string)$num[0] . '</mn>
                                    </mrow>
                                </mfrac>
                                <mo>(</mo>' .
                                $result_0
                                . '<mi>x</mi>
                                <mo>' . $sign[2] . '</mo>
                                <mn>' . (string)$num[2] . '</mn>
                                <mo>)</mo>
                            </math>
                            </div>
                        ';
                    }
                    break;
                }
            }
        }
    } else if ($level == '2') {
        $style = random_int(0, 3);
        if ($style < 2) {
            for (;;) {
                $num = [random_int(1, 9), random_int(1, 9)];
                $sign = [get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                if ($a != $b && $a + $b != 0) {
                    $answer = [$a + $b, $a * $b];
                    $result = '
                        <div>
                        <math display = "block">
                            <mo>(</mo>
                            <mi>x</mi>
                            <mo>' . $sign[0] . '</mo>
                            <mn>' . (string)$num[0] . '</mn>
                            <mo>)</mo>
                            <mo>(</mo>
                            <mi>x</mi>
                            <mo>' . $sign[1] . '</mo>
                            <mn>' . (string)$num[1] . '</mn>
                            <mo>)</mo>
                        </math>
                        </div>
                    ';
                    break;
                }
            }
        } else if ($style == 2) {
            $num = [random_int(1, 9)];
            $sign = [get_sign()];
            $sign2 = [get_sign2($sign[0])];
            $a = $num[0] * $sign2[0];
            $answer = [2 * $a, $a * $a];
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mrow>
                            <mo>(</mo>
                            <mi>x</mi>
                            <mo>' . $sign[0] . '</mo>
                            <mn>' . (string)$num[0] . '</mn>
                            <mo>)</mo>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                </math>
                </div>
            ';
        } else {
            $num = [random_int(1, 9)];
            $sign = [get_sign()];
            $sign2 = [get_sign2($sign[0])];
            $a = $num[0] * $sign2[0];
            $answer = [-1 * $a * $a];
            $result = '
                <div>
                <math display = "block">
                    <mo>(</mo>
                    <mi>x</mi>
                    <mo>+</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>)</mo>
                    <mo>(</mo>
                    <mi>x</mi>
                    <mo>-</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>)</mo>
                </math>
                </div>
            ';
        }
    } else if ($level == '3') {
        $style = random_int(0, 3);
        if ($style < 2) {
            for (;;) {
                $num = [random_int(1, 9), random_int(1, 9), random_int(2, 9)];
                $sign = [get_sign(), get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                $c = $num[2] * $sign2[2];
                if ($a != $b && $a + $b != 0) {
                    $answer = [$c, $c * ($a + $b), $c * $a * $b];
                    if ($sign[2] == '+') {
                        $result_0 = '
                            <mn>' . (string)$num[2] . '</mn>
                        ';
                    } else {
                        $result_0 = '
                            <mo>' . $sign[2] . '</mo>
                            <mn>' . (string)$num[2] . '</mn>
                        ';
                    }
                    $result = '
                        <div>
                        <math display = "block">' .
                            $result_0
                            . '<mo>(</mo>
                            <mi>x</mi>
                            <mo>' . $sign[0] . '</mo>
                            <mn>' . (string)$num[0] . '</mn>
                            <mo>)</mo>
                            <mo>(</mo>
                            <mi>x</mi>
                            <mo>' . $sign[1] . '</mo>
                            <mn>' . (string)$num[1] . '</mn>
                            <mo>)</mo>
                        </math>
                        </div>
                    ';
                    break;
                }
            }
        } else if ($style == 2) {
            $num = [random_int(1, 9), random_int(2, 9)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$b, $b * 2 * $a, $b * $a * $a];
            if ($sign[1] == '+') {
                $result_0 = '
                    <mn>' . (string)$num[1] . '</mn>
                ';
            } else {
                $result_0 = '
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                ';
            }
            $result = '
                <div>
                <math display = "block">' .
                    $result_0
                    . '<msup>
                        <mrow>
                            <mo>(</mo>
                            <mi>x</mi>
                            <mo>' . $sign[0] . '</mo>
                            <mn>' . (string)$num[0] . '</mn>
                            <mo>)</mo>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                </math>
                </div>
            ';
        } else {
            $num = [random_int(1, 9), random_int(2, 9)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$b, $b * -1 * $a * $a];
            if ($sign[1] == '+') {
                $result_0 = '
                    <mn>' . (string)$num[1] . '</mn>
                ';
            } else {
                $result_0 = '
                    <mo>' . $sign[1] . '</mo>
                    <mn>' . (string)$num[1] . '</mn>
                ';
            }
            $result = '
                <div>
                <math display = "block">' .
                    $result_0
                    . '<mo>(</mo>
                    <mi>x</mi>
                    <mo>+</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>)</mo>
                    <mo>(</mo>
                    <mi>x</mi>
                    <mo>-</mo>
                    <mn>' . (string)$num[0] . '</mn>
                    <mo>)</mo>
                </math>
                </div>
            ';
        }
    } else if ($level == '4') {
        $style = random_int(0, 3);
        if ($style < 2) {
            for (;;) {
                $num = [random_int(2, 9), random_int(1, 9), random_int(2, 9), random_int(1, 9)];
                $sign = [get_sign(), get_sign(), get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                $c = $num[2] * $sign2[2];
                $d = $num[3] * $sign2[3];
                if (($a != $c || $b != $d) && $a * $d + $b * $c != 0) {
                    $answer = [$a * $c, $a * $d + $b * $c, $b * $d];
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
                            <mo>(</mo>' .
                            $result_0
                            . '<mi>x</mi>
                            <mo>' . $sign[1] . '</mo>
                            <mn>' . (string)$num[1] . '</mn>
                            <mo>)</mo>
                            <mo>(</mo>' .
                            $result_1
                            . '<mi>x</mi>
                            <mo>' . $sign[3] . '</mo>
                            <mn>' . (string)$num[3] . '</mn>
                            <mo>)</mo>
                        </math>
                        </div>
                    ';
                    break;
                }
            }
        } else if ($style == 2) {
            $num = [random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$a * $a, 2 * $a * $b, $b * $b];
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
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mrow>
                            <mo>(</mo>' .
                            $result_0
                            . '<mi>x</mi>
                            <mo>' . $sign[1] . '</mo>
                            <mn>' . (string)$num[1] . '</mn>
                            <mo>)</mo>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                </math>
                </div>
            ';
        } else {
            $num = [random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$a * $a, -1 * $b * $b];
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
            $result = '
                <div>
                <math display = "block">
                    <mo>(</mo>' .
                    $result_0
                    . '<mi>x</mi>
                    <mo>+</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>)</mo>
                    <mo>(</mo>' .
                    $result_0
                    . '<mi>x</mi>
                    <mo>-</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>)</mo>
                </math>
                </div>
            ';
        }
    } else if ($level == '5') {
        $style = random_int(0, 3);
        if ($style < 2) {
            for (;;) {
                $num = [random_int(2, 99), random_int(1, 99), random_int(2, 99), random_int(1, 99)];
                $sign = [get_sign(), get_sign(), get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2]), get_sign2($sign[3])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                $c = $num[2] * $sign2[2];
                $d = $num[3] * $sign2[3];
                if (($a != $c || $b != $d) && $a * $d + $b * $c != 0) {
                    $answer = [$a * $c, $a * $d + $b * $c, $b * $d];
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
                            <mo>(</mo>' .
                            $result_0
                            . '<mi>x</mi>
                            <mo>' . $sign[1] . '</mo>
                            <mn>' . (string)$num[1] . '</mn>
                            <mo>)</mo>
                            <mo>(</mo>' .
                            $result_1
                            . '<mi>x</mi>
                            <mo>' . $sign[3] . '</mo>
                            <mn>' . (string)$num[3] . '</mn>
                            <mo>)</mo>
                        </math>
                        </div>
                    ';
                    break;
                }
            }
        } else if ($style == 2) {
            $num = [random_int(2, 99), random_int(1, 99)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$a * $a, 2 * $a * $b, $b * $b];
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
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mrow>
                            <mo>(</mo>' .
                            $result_0
                            . '<mi>x</mi>
                            <mo>' . $sign[1] . '</mo>
                            <mn>' . (string)$num[1] . '</mn>
                            <mo>)</mo>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                </math>
                </div>
            ';
        } else {
            $num = [random_int(2, 99), random_int(1, 99)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$a * $a, -1 * $b * $b];
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
            $result = '
                <div>
                <math display = "block">
                    <mo>(</mo>' .
                    $result_0
                    . '<mi>x</mi>
                    <mo>+</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>)</mo>
                    <mo>(</mo>' .
                    $result_0
                    . '<mi>x</mi>
                    <mo>-</mo>
                    <mn>' . (string)$num[1] . '</mn>
                    <mo>)</mo>
                </math>
                </div>
            ';
        }
    }
    return [$result, $answer];
}

function write4($level, $answer) {
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
                    <mi>x</mi>
                    <mrow class = "input_box_block box_block_1">
                        <mn class = "input_box_display box_display_1">1</mn>
                        <mn class = "input_box_set box_set_1">00</mn>
                        <mo class = "input_box_sign box_sign_1"></mo>
                        <mn class = "input_box box_1"></mn>
                        <button class = "input_box_button box_button_1" type = "button">000</button>
                    </mrow>
                </mrow>
            </math>
            </div>
        ';
    } else if ($level == '2') {
        if (count($answer) == 2) {
            $result = '
                <div>
                <math class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_0">
                            <mn class = "input_box_display box_display_0">1</mn>
                            <mn class = "input_box_set box_set_0">00</mn>
                            <mo class = "input_box_sign box_sign_0"></mo>
                            <mn class = "input_box box_0"></mn>
                            <button class = "input_box_button box_button_0" type = "button">000</button>
                        </mrow>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_1">
                            <mn class = "input_box_display box_display_1">1</mn>
                            <mn class = "input_box_set box_set_1">00</mn>
                            <mo class = "input_box_sign box_sign_1"></mo>
                            <mn class = "input_box box_1"></mn>
                            <button class = "input_box_button box_button_1" type = "button">000</button>
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
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_0">    
                            <mn class = "input_box_display box_display_0">1</mn>
                            <mn class = "input_box_set box_set_0">00</mn>
                            <mo class = "input_box_sign box_sign_0"></mo>
                            <mn class = "input_box box_0"></mn>
                            <button class = "input_box_button box_button_0" type = "button">000</button>
                        </mrow>
                    </mrow>
                </math>
                </div>
            ';
        }
    } else {
        if (count($answer) == 3) {
            $result = '
                <div>
                <math class = "input_area_inner" class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mrow class = "input_box_block box_block_0">
                            <mn class = "input_box_display box_display_0">0</mn>
                            <mn class = "input_box_set box_set_0">00</mn>
                            <mo class = "input_box_sign box_sign_0"></mo>
                            <mn class = "input_box box_0"></mn>
                            <button class = "input_box_button box_button_0" type = "button">000</button>
                        </mrow>
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_1">
                            <mn class = "input_box_display box_display_1">1</mn>
                            <mn class = "input_box_set box_set_1">00</mn>
                            <mo class = "input_box_sign box_sign_1"></mo>
                            <mn class = "input_box box_1"></mn>
                            <button class = "input_box_button box_button_1" type = "button">000</button>
                        </mrow>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_2">
                            <mn class = "input_box_display box_display_2">1</mn>
                            <mn class = "input_box_set box_set_2">00</mn>
                            <mo class = "input_box_sign box_sign_2"></mo>
                            <mn class = "input_box box_2"></mn>
                            <button class = "input_box_button box_button_2" type = "button">000</button>
                        </mrow>
                    </mrow>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math class = "input_area_inner" class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mrow class = "input_box_block box_block_0">
                            <mn class = "input_box_display box_display_0">0</mn>
                            <mn class = "input_box_set box_set_0">00</mn>
                            <mo class = "input_box_sign box_sign_0"></mo>
                            <mn class = "input_box box_0"></mn>
                            <button class = "input_box_button box_button_0" type = "button">000</button>
                        </mrow>
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_1">
                            <mn class = "input_box_display box_display_1">1</mn>
                            <mn class = "input_box_set box_set_1">00</mn>
                            <mo class = "input_box_sign box_sign_1"></mo>
                            <mn class = "input_box box_1"></mn>
                            <button class = "input_box_button box_button_1" type = "button">000</button>
                        </mrow>
                    </mrow>
                </math>
                </div>
            ';
        }
    }
    return $result;
}

function feedback4($level, $answer) {
    $answer_sign = [];
    for ($i = 0; $i < count($answer); $i += 1) {
        if (strval($answer[$i]) < 0) {
            $answer_sign[] = '-';
        } else {
            if ($level == '1') {
                if ($i == 0) {
                    $answer_sign[] = '';
                } else {
                    $answer_sign[] = '+';
                }
            } else if ($level == '2') {
                $answer_sign[] = '+';
            } else {
                if (count($answer) == 3) {
                    if ($i == 0) {
                        $answer_sign[] = '';
                    } else {
                        $answer_sign[] = '+';
                    }
                } else {
                    if ($i == 0) {
                        $answer_sign[] = '';
                    } else {
                        $answer_sign[] = '+';
                    }
                }
            }
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
                    <mi>x</mi>
                    <mrow class = "input_box_block box_block_1">
                        <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                        <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                    </mrow>
                </mrow>
            </math>
            </div>
        ';
    } else if ($level == '2') {
        if (count($answer) == 2) {
            $result = '
                <div>
                <math class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_0">
                            <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                            <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                        </mrow>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_1">
                            <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                            <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
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
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_0">    
                            <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                            <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                        </mrow>
                    </mrow>
                </math>
                </div>
            ';
        }
    } else {
        if (count($answer) == 3) {
            $result = '
                <div>
                <math class = "input_area_inner" class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mrow class = "input_box_block box_block_0">
                            <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                            <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                        </mrow>
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_1">
                            <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                            <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                        </mrow>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_2">
                            <mo class = "input_box_sign box_sign_2">' . $answer_sign[2] . '</mo>
                            <mn class = "input_box box_2">' . (string)abs($answer[2]) . '</mn>
                        </mrow>
                    </mrow>
                </math>
                </div>
            ';
        } else {
            $result = '
                <div>
                <math class = "input_area_inner" class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mrow class = "input_box_block box_block_0">
                            <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                            <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                        </mrow>
                        <msup>
                            <mi>x</mi>
                            <mn>2</mn>
                        </msup>
                        <mrow class = "input_box_block box_block_1">
                            <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                            <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                        </mrow>
                    </mrow>
                </math>
                </div>
            ';
        }
    }
    return $result;
}
