<?php
function make5($level) {
    if ($level == '1') {
        $num = [random_int(2, 9), random_int(1, 9)];
        $sign = [get_sign(), get_sign()];
        $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
        $a = $num[0] * $sign2[0];
        $b = $num[1] * $sign2[1];
        $answer = [$a, $b];
        if ($a * $b > 0) {
            $info_join = '+';
        } else {
            $info_join = '-';
        }
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
            <math display = "block">' .
                $result_0
                . '<mi>x</mi>
                <mo>' . $info_join . '</mo>
                <mn>' . (string)abs($a * $b) . '</mn>
            </math>
            </div>
        ';
    } else if ($level == '2') {
        for (;;) {
            $num = [random_int(2, 9), random_int(2, 9), random_int(1, 9)];
            $sign = [get_sign(), '+', get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $c = $num[2] * $sign2[2];
            if (get_gcd(abs($b), abs($c)) == 1) {
                $answer = [$a, $b, $c];
                if ($a * $c > 0) {
                    $info_join = '+';
                } else {
                    $info_join = '-';
                }
                $result = '
                    <div>
                    <math display = "block">
                        <mn>' . (string)($a * $b) . '</mn>
                        <mi>x</mi>
                        <mo>' . $info_join . '</mo>
                        <mn>' . (string)abs($a * $c) . '</mn>
                    </math>
                    </div>
                ';
                break;
            }
        }
    } else if ($level == '3') {
        $style = random_int(0, 3);
        if ($style < 2) {
            for (;;) {
                $num = [random_int(1, 9), random_int(1, 9)];
                $sign = [get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                if (abs($a) != abs($b)) {
                    $answer = [$a, $b];
                    if ($a + $b < 0) {
                        $info_join_1 = '-';
                    } else {
                        $info_join_1 = '+';
                    }
                    if ($a * $b < 0) {
                        $info_join_2 = '-';
                    } else {
                        $info_join_2 = '+';
                    }
                    if (abs($a + $b) != 1) {
                        $result = '
                            <div>
                            <math display = "block">
                                <msup>
                                    <mi>x</mi>
                                    <mn>2</mn>
                                </msup>
                                <mo>' . $info_join_1 . '</mo>
                                <mn>' . (string)(abs($a + $b)) . '</mn>
                                <mi>x</mi>
                                <mo>' . $info_join_2 . '</mo>
                                <mn>' . (string)(abs($a * $b)) . '</mn>
                            </math>
                            </div>
                        ';
                    } else {
                        $result = '
                            <div>
                            <math display = "block">
                                <msup>
                                    <mi>x</mi>
                                    <mn>2</mn>
                                </msup>
                                <mo>' . $info_join_1 . '</mo>
                                <mi>x</mi>
                                <mo>' . $info_join_2 . '</mo>
                                <mn>' . (string)(abs($a * $b)) . '</mn>
                            </math>
                            </div>
                        ';
                    }
                    break;
                }
            }
        } else if ($style == 2) {
            $num = [random_int(1, 9)];
            $sign = [get_sign()];
            $sign2 = [get_sign2($sign[0])];
            $a = $num[0] * $sign2[0];
            $answer = [$a];
            if ($a < 0) {
                $info_join = '-';
            } else {
                $info_join = '+';
            }
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mi>x</mi>
                        <mn>2</mn>
                    </msup>
                    <mo>' . $info_join . '</mo>
                    <mn>' . (string)(abs(2 * $a)) . '</mn>
                    <mi>x</mi>
                    <mo>+</mo>
                    <mn>' . (string)(abs($a * $a)) . '</mn>
                </math>
                </div>
            ';
        } else {
            $num = [random_int(1, 9)];
            $sign = ['+'];
            $sign2 = [get_sign2($sign[0])];
            $a = $num[0] * $sign2[0];
            $answer = [$a, -1 * $a];
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mi>x</mi>
                        <mn>2</mn>
                    </msup>
                    <mo>-</mo>
                    <mn>' . (string)(abs($a * $a)) . '</mn>
                </math>
                </div>
            ';
        }
    } else if ($level == '4') {
        $style = random_int(0, 3);
        if ($style < 2) {
            for (;;) {
                $num = [random_int(1, 9), random_int(1, 9), random_int(2, 9)];
                $sign = [get_sign(), get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                $c = $num[2] * $sign2[2];
                if (abs($a) != abs($b)) {
                    $answer = [$c, $a, $b];
                    if (($a + $b) * $c < 0) {
                        $info_join_1 = '-';
                    } else {
                        $info_join_1 = '+';
                    }
                    if ($a * $b * $c < 0) {
                        $info_join_2 = '-';
                    } else {
                        $info_join_2 = '+';
                    }
                    $result = '
                        <div>
                        <math display = "block">
                            <msup>
                                <mrow>
                                    <mn>' . (string)$c . '</mn>
                                    <mi>x</mi>
                                </mrow>
                                <mn>2</mn>
                            </msup>
                            <mo>' . $info_join_1 . '</mo>
                            <mn>' . (string)(abs(($a + $b) * $c)) . '</mn>
                            <mi>x</mi>
                            <mo>' . $info_join_2 . '</mo>
                            <mn>' . (string)(abs($a * $b * $c)) . '</mn>
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
            $answer = [$b, $a];
            if ($a * $b < 0) {
                $info_join_1 = '-';
            } else {
                $info_join_1 = '+';
            }
            if ($a * $a * $b < 0) {
                $info_join_2 = '-';
            } else {
                $info_join_2 = '+';
            }
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mrow>
                            <mn>' . (string)$b . '</mn>
                            <mi>x</mi>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                    <mo>' . $info_join_1 . '</mo>
                    <mn>' . (string)(abs(2 * $a * $b)) . '</mn>
                    <mi>x</mi>
                    <mo>' . $info_join_2 . '</mo>
                    <mn>' . (string)(abs($a * $a * $b)) . '</mn>
                </math>
                </div>
            ';
        } else {
            $num = [random_int(1, 9), random_int(2, 9)];
            $sign = ['+', get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$b, $a, -1 * $a];
            if ($a * $a * $b < 0) {
                $info_join = '+';
            } else {
                $info_join = '-';
            }
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mrow>
                            <mn>' . (string)$b . '</mn>
                            <mi>x</mi>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                    <mo>' . $info_join . '</mo>
                    <mn>' . (string)(abs($a * $a * $b)) . '</mn>
                </math>
                </div>
            ';
        }
    } else if ($level == '5') {
        $style = random_int(0, 3);
        if ($style < 2) {
            for (;;) {
                $num = [random_int(1, 99), random_int(1, 99), random_int(2, 99)];
                $sign = [get_sign(), get_sign(), get_sign()];
                $sign2 = [get_sign2($sign[0]), get_sign2($sign[1]), get_sign2($sign[2])];
                $a = $num[0] * $sign2[0];
                $b = $num[1] * $sign2[1];
                $c = $num[2] * $sign2[2];
                if (abs($a) != abs($b)) {
                    $answer = [$c, $a, $b];
                    if (($a + $b) * $c < 0) {
                        $info_join_1 = '-';
                    } else {
                        $info_join_1 = '+';
                    }
                    if ($a * $b * $c < 0) {
                        $info_join_2 = '-';
                    } else {
                        $info_join_2 = '+';
                    }
                    $result = '
                        <div>
                        <math display = "block">
                            <msup>
                                <mrow>
                                    <mn>' . (string)$c . '</mn>
                                    <mi>x</mi>
                                </mrow>
                                <mn>2</mn>
                            </msup>
                            <mo>' . $info_join_1 . '</mo>
                            <mn>' . (string)(abs(($a + $b) * $c)) . '</mn>
                            <mi>x</mi>
                            <mo>' . $info_join_2 . '</mo>
                            <mn>' . (string)(abs($a * $b * $c)) . '</mn>
                        </math>
                        </div>
                    ';
                    break;
                }
            }
        } else if ($style == 2) {
            $num = [random_int(1, 99), random_int(2, 99)];
            $sign = [get_sign(), get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$b, $a];
            if ($a * $b < 0) {
                $info_join_1 = '-';
            } else {
                $info_join_1 = '+';
            }
            if ($a * $a * $b < 0) {
                $info_join_2 = '-';
            } else {
                $info_join_2 = '+';
            }
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mrow>
                            <mn>' . (string)$b . '</mn>
                            <mi>x</mi>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                    <mo>' . $info_join_1 . '</mo>
                    <mn>' . (string)(abs(2 * $a * $b)) . '</mn>
                    <mi>x</mi>
                    <mo>' . $info_join_2 . '</mo>
                    <mn>' . (string)(abs($a * $a * $b)) . '</mn>
                </math>
                </div>
            ';
        } else {
            $num = [random_int(1, 99), random_int(2, 99)];
            $sign = ['+', get_sign()];
            $sign2 = [get_sign2($sign[0]), get_sign2($sign[1])];
            $a = $num[0] * $sign2[0];
            $b = $num[1] * $sign2[1];
            $answer = [$b, $a, -1 * $a];
            if ($a * $a * $b < 0) {
                $info_join = '+';
            } else {
                $info_join = '-';
            }
            $result = '
                <div>
                <math display = "block">
                    <msup>
                        <mrow>
                            <mn>' . (string)$b . '</mn>
                            <mi>x</mi>
                        </mrow>
                        <mn>2</mn>
                    </msup>
                    <mo>' . $info_join . '</mo>
                    <mn>' . (string)(abs($a * $a * $b)) . '</mn>
                </math>
                </div>
            ';
        }
    }
    return [$result, $answer];
}

function write5($level, $answer) {
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
                    <mo>(</mo>
                    <mi>x</mi>
                    <mrow class = "input_box_block box_block_1">
                        <mn class = "input_box_display box_display_1">1</mn>
                        <mn class = "input_box_set box_set_1">00</mn>
                        <mo class = "input_box_sign box_sign_1"></mo>
                        <mn class = "input_box box_1"></mn>
                        <button class = "input_box_button box_button_1" type = "button">000</button>
                    </mrow>
                    <mo>)</mo>
                </mrow>
            </math>
            </div>
        ';
    } else if ($level == '2') {
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
                    <mo>(</mo>
                    <mrow class = "input_box_block box_block_1">
                        <mn class = "input_box_display box_display_1">0</mn>
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
                    <mo>)</mo>
                </mrow>
            </math>
            </div>
        ';
    } else if ($level == '3') {
        if (count($answer) == 2) {
            $result = '
                <div>
                <math class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_0">
                            <mn class = "input_box_display box_display_0">1</mn>
                            <mn class = "input_box_set box_set_0">00</mn>
                            <mo class = "input_box_sign box_sign_0"></mo>
                            <mn class = "input_box box_0"></mn>
                            <button class = "input_box_button box_button_0" type = "button">000</button>
                        </mrow>
                        <mo>)</mo>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_1">
                            <mn class = "input_box_display box_display_1">1</mn>
                            <mn class = "input_box_set box_set_1">00</mn>
                            <mo class = "input_box_sign box_sign_1"></mo>
                            <mn class = "input_box box_1"></mn>
                            <button class = "input_box_button box_button_1" type = "button">000</button>
                        </mrow>
                        <mo>)</mo>
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
                            <mrow class = "input_area_subblock">
                                <mo>(</mo>
                                <mi>x</mi>
                                <mrow class = "input_box_block box_block_0">
                                    <mn class = "input_box_display box_display_0">1</mn>
                                    <mn class = "input_box_set box_set_0">00</mn>
                                    <mo class = "input_box_sign box_sign_0"></mo>
                                    <mn class = "input_box box_0"></mn>
                                    <button class = "input_box_button box_button_0" type = "button">000</button>
                                </mrow>
                                <mo>)</mo>
                            </mrow>
                            <mn>2</mn>
                        </msup>
                    </mrow>
                </math>
                </div>
            ';
        }
    } else {
        if (count($answer) == 3) {
            $result = '
                <div>
                <math class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mrow class = "input_box_block box_block_0">
                            <mn class = "input_box_display box_display_0">0</mn>
                            <mn class = "input_box_set box_set_0">+0</mn>
                            <mo class = "input_box_sign box_sign_0"></mo>
                            <mn class = "input_box box_0"></mn>
                            <button class = "input_box_button box_button_0" type = "button">000</button>
                        </mrow>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_1">
                            <mn class = "input_box_display box_display_1">1</mn>
                            <mn class = "input_box_set box_set_1">+0</mn>
                            <mo class = "input_box_sign box_sign_1"></mo>
                            <mn class = "input_box box_1"></mn>
                            <button class = "input_box_button box_button_1" type = "button">000</button>
                        </mrow>
                        <mo>)</mo>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_2">
                            <mn class = "input_box_display box_display_2">1</mn>
                            <mn class = "input_box_set box_set_2">+0</mn>
                            <mo class = "input_box_sign box_sign_2"></mo>
                            <mn class = "input_box box_2"></mn>
                            <button class = "input_box_button box_button_2" type = "button">000</button>
                        </mrow>
                        <mo>)</mo>
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
                        <msup>
                            <mrow class = "input_area_subblock">
                                <mo>(</mo>
                                <mi>x</mi>
                                <mrow class = "input_box_block box_block_1">
                                    <mn class = "input_box_display box_display_1">1</mn>
                                    <mn class = "input_box_set box_set_1">00</mn>
                                    <mo class = "input_box_sign box_sign_1"></mo>
                                    <mn class = "input_box box_1"></mn>
                                    <button class = "input_box_button box_button_1" type = "button">000</button>
                                </mrow>
                                <mo>)</mo>
                            </mrow>
                            <mn>2</mn>
                        </msup>
                    </mrow>
                </math>
                </div>
            ';
        }
    }
    return $result;
}

function feedback5($level, $answer) {
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
                if ($i < 2) {
                    $answer_sign[] = '';
                } else {
                    $answer_sign[] = '+';
                }
            } else if ($level == '3') {
                $answer_sign[] = '+';
            } else {
                if ($i == 0) {
                    $answer_sign[] = '';
                } else {
                    $answer_sign[] = '+';
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
                    <mo>(</mo>
                    <mi>x</mi>
                    <mrow class = "input_box_block box_block_1">
                        <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                        <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                    </mrow>
                    <mo>)</mo>
                </mrow>
            </math>
            </div>
        ';
    } else if ($level == '2') {
        $result = '
            <div>
            <math class = "input_area_inner" display = "block">
                <mrow class = "input_area_subblock">
                    <mo>=</mo>
                    <mrow class = "input_box_block box_block_0">
                        <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                        <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                    </mrow>
                    <mo>(</mo>
                    <mrow class = "input_box_block box_block_1">
                        <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                        <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                    </mrow>
                    <mi>x</mi>
                    <mrow class = "input_box_block box_block_2">
                        <mo class = "input_box_sign box_sign_2">' . $answer_sign[2] . '</mo>
                        <mn class = "input_box box_2">' . (string)abs($answer[2]) . '</mn>
                    </mrow>
                    <mo>)</mo>
                </mrow>
            </math>
            </div>
        ';
    } else if ($level == '3') {
        if (count($answer) == 2) {
            $result = '
                <div>
                <math class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_0">
                            <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                            <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                        </mrow>
                        <mo>)</mo>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_1">
                            <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                            <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                        </mrow>
                        <mo>)</mo>
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
                            <mrow class = "input_area_subblock">
                                <mo>(</mo>
                                <mi>x</mi>
                                <mrow class = "input_box_block box_block_0">
                                    <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                                    <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                                </mrow>
                                <mo>)</mo>
                            </mrow>
                            <mn>2</mn>
                        </msup>
                    </mrow>
                </math>
                </div>
            ';
        }
    } else {
        if (count($answer) == 3) {
            $result = '
                <div>
                <math class = "input_area_inner" display = "block">
                    <mrow class = "input_area_subblock">
                        <mo>=</mo>
                        <mrow class = "input_box_block box_block_0">
                            <mo class = "input_box_sign box_sign_0">' . $answer_sign[0] . '</mo>
                            <mn class = "input_box box_0">' . (string)abs($answer[0]) . '</mn>
                        </mrow>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_1">
                            <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                            <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                        </mrow>
                        <mo>)</mo>
                        <mo>(</mo>
                        <mi>x</mi>
                        <mrow class = "input_box_block box_block_2">
                            <mo class = "input_box_sign box_sign_2">' . $answer_sign[2] . '</mo>
                            <mn class = "input_box box_2">' . (string)abs($answer[2]) . '</mn>
                        </mrow>
                        <mo>)</mo>
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
                        <msup>
                            <mrow class = "input_area_subblock">
                                <mo>(</mo>
                                <mi>x</mi>
                                <mrow class = "input_box_block box_block_1">
                                    <mo class = "input_box_sign box_sign_1">' . $answer_sign[1] . '</mo>
                                    <mn class = "input_box box_1">' . (string)abs($answer[1]) . '</mn>
                                </mrow>
                                <mo>)</mo>
                            </mrow>
                            <mn>2</mn>
                        </msup>
                    </mrow>
                </math>
                </div>
            ';
        }
    }
    return $result;
}
