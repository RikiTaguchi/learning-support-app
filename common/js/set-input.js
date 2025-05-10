document.addEventListener('DOMContentLoaded', () => {
    const buttonsInput = [];
    const boxes = [];
    const boxes2 = [];
    const boxes3 = [];
    const boxes4 = [];
    const boxes5 = [];
    const boxes6 = [];
    const buttonNext = document.querySelector('.button_n');
    const buttonBack = document.querySelector('.button_b');
    const buttonReset = document.querySelector('.button_r');
    const buttonChange = document.querySelector('.button_c');
    const buttonResult = document.querySelector('.button_l');
    const answerCount = document.querySelector('.answer_count');
    let inputTargetNumber = document.querySelector('.input_target');
    const buttonCheck = document.querySelector('.button_a');
    const buttonPass = document.querySelector('.button_p');
    const answers = [];
    const type = document.querySelector('.info_type');
    const level = document.querySelector('.info_level');
    const questionCorrect = document.querySelector('.question_correct');
    const formCorrect = document.querySelector('.form_correct');
    const formCorrect2 = document.querySelector('.form_correct2');
    const formNext = document.querySelector('.form_next_area');
    const formResult = document.querySelector('.result_area');
    const questionCount = document.querySelector('.question_count');
    const questionNumber = document.querySelector('.question_number');
    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };
    const slideAnswer = {
        transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(0, 1, 0, 0deg)'],
    };
    const displayAnswer = () => {
        for (let i = 0; i < Number(answerCount.textContent); i++) {
            boxes[i].style.color = 'red';
            boxes2[i].style.color = 'red';
            boxes3[i].style.borderColor = '#e6ffff';
            if (Number((answers[i].textContent).replace('+', '')) < 0) {
                boxes[i].textContent = Math.abs(Number((answers[i].textContent).replace('+', ''))).toString();
                boxes2[i].textContent = '-';
            } else {
                boxes[i].textContent = Math.abs(Number((answers[i].textContent).replace('+', ''))).toString();
                if (boxes4[i].textContent === '0') {
                    boxes2[i].textContent = '';
                } else {
                    boxes2[i].textContent = '+';
                }
            }
            boxes3[i].animate(slideAnswer, options);
        }
    }
    const imgCorrect = document.querySelector('.img_correct');
    const imgIncorrect = document.querySelector('.img_incorrect');
    const imgPass = document.querySelector('.img_pass');
    const options2 = {
        duration: 250,
        easing: 'ease',
        fill: 'forwards',
    };
    const displayImg = {
        transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(0, 1, 0, 0deg)'],
    };
    const questionPanel = document.querySelector('.question_panel');
    const options3 = {
        duration: 250,
        easing: 'ease',
        fill: 'forwards',
    };
    const displayPanel = {
        transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(0, 1, 0, 0deg)'],
    };
    const infoFeedback = document.querySelector('.info_feedback');
    const paramFeedback = document.querySelector('.param_feedback');
    const finishTimeH = document.querySelector('.finish_time_h');
    const finishTimeM = document.querySelector('.finish_time_m');
    const finishTimeS = document.querySelector('.finish_time_s');
    const timeArea = document.querySelector('.time_area');
    const timeArea2 = document.querySelector('.time_area2');

    if (questionCount.textContent === questionNumber.textContent) {
        formNext.style.display = 'none';
        formResult.style.display = 'flex';
    }

    questionPanel.animate(displayPanel, options3);
    
    for (let i = 0; i < 12; i++) {
        buttonsInput.push(document.querySelector('.button_' + i.toString()));
        buttonsInput[i].addEventListener('click', () => {
            const target = document.querySelector('.box_' + inputTargetNumber.textContent);
            const target2 = document.querySelector('.box_sign_' + inputTargetNumber.textContent);
            const target3 = document.querySelector('.box_display_' + inputTargetNumber.textContent);
            if (i < 10) {
                if (target2.textContent === '' && target3.textContent === '1') {
                    target2.textContent = '+';
                }
                target.textContent = target.textContent + i.toString();
            } else if (i === 10) {
                target2.textContent = '+';
            } else if (i === 11) {
                target2.textContent = '-';
            }

            setButton();
        });
    }

    for (let i = 0; i < Number(answerCount.textContent); i++) {
        boxes.push(document.querySelector('.box_' + i.toString()));
        boxes2.push(document.querySelector('.box_sign_' + i.toString()));
        boxes3.push(document.querySelector('.box_block_' + i.toString()));
        boxes4.push(document.querySelector('.box_display_' + i.toString()));
        boxes5.push(document.querySelector('.box_set_' + i.toString()));
        boxes6.push(document.querySelector('.box_button_' + i.toString()));
        answers.push(document.querySelector('.answer_' + i.toString()));
    }

    boxes3[0].style.borderColor = '#ff69b4';

    for (let i = 0; i < Number(answerCount.textContent); i++) {
        boxes6[i].addEventListener('click', () => {
            for (let j = 0; j < Number(answerCount.textContent); j++) {
                if (i === j) {
                    boxes3[j].style.borderColor = '#ff69b4';
                    inputTargetNumber.textContent = j.toString();
                } else {
                    boxes3[j].style.borderColor = '#e6ffff';
                }
            }
        });
    }

    buttonNext.addEventListener('click', () => {
        if (Number(inputTargetNumber.textContent) < Number(answerCount.textContent) - 1) {
            boxes3[Number(inputTargetNumber.textContent)].style.borderColor = '#e6ffff';
            inputTargetNumber.textContent = (Number(inputTargetNumber.textContent) + 1).toString();
            boxes3[Number(inputTargetNumber.textContent)].style.borderColor = '#ff69b4';
        }
    });

    buttonBack.addEventListener('click', () => {
        if (Number(inputTargetNumber.textContent) > 0) {
            boxes3[Number(inputTargetNumber.textContent)].style.borderColor = '#e6ffff';
            inputTargetNumber.textContent = (Number(inputTargetNumber.textContent) - 1).toString();
            boxes3[Number(inputTargetNumber.textContent)].style.borderColor = '#ff69b4';
        }
    });

    buttonReset.addEventListener('click', () => {
        const target = document.querySelector('.box_' + inputTargetNumber.textContent);
        const target2 = document.querySelector('.box_sign_' + inputTargetNumber.textContent);
        target.textContent = '';
        target2.textContent = '';
        setButton();
    });

    buttonCheck.addEventListener('click', () => {
        for (let i = 0; i < 12; i++) {
            buttonsInput[i].style.pointerEvents = 'none';
        }
        for (let i = 0; i < Number(answerCount.textContent); i++) {
            boxes3[i].style.borderColor = '#e6ffff';
            boxes6[i].style.pointerEvents = 'none';
        }

        buttonNext.style.pointerEvents = 'none';
        buttonBack.style.pointerEvents = 'none';
        buttonReset.style.pointerEvents = 'none';
        buttonCheck.style.pointerEvents = 'none';
        buttonPass.style.pointerEvents = 'none';
        buttonChange.style.pointerEvents = 'auto';
        buttonResult.style.pointerEvents = 'auto';

        buttonCheck.style.backgroundColor = 'gray';
        buttonPass.style.backgroundColor = 'gray';
        buttonChange.style.backgroundColor = 'rgb(0, 149, 224)';
        buttonResult.style.backgroundColor = 'rgb(0, 149, 224)';

        let userInput;
        let userAnswer;
        let checkResult = true;

        for (let i = 0; i < Number(answerCount.textContent); i++) {
            if (boxes2[i].textContent === '-') {
                userInput = Number(boxes[i].textContent) * -1;
            } else {
                userInput = Number(boxes[i].textContent);
            }
            userAnswer = Number((answers[i].textContent).replace('+', ''));
            if (userInput !== userAnswer) {
                checkResult = false;
                break;
            }
        }

        if (type.textContent === '5') {
            if (level.textContent === '3' && answerCount.textContent === '2') {
                let userInput0;
                let userInput1;
                let userAnswer0;
                let userAnswer1;

                if (boxes2[0].textContent === '-') {
                    userInput0 = Number(boxes[0].textContent) * -1;
                } else {
                    userInput0 = Number(boxes[0].textContent);
                }
                userAnswer0 = Number((answers[0].textContent).replace('+', ''));

                if (boxes2[1].textContent === '-') {
                    userInput1 = Number(boxes[1].textContent) * -1;
                } else {
                    userInput1 = Number(boxes[1].textContent);
                }
                userAnswer1 = Number((answers[1].textContent).replace('+', ''));

                if (userInput0 === userAnswer1 && userInput1 === userAnswer0) {
                    checkResult = true;
                }
            } else if ((level.textContent === '4' || level.textContent === '5') && answerCount.textContent === '3') {
                let userInput0;
                let userInput1;
                let userInput2;
                let userAnswer0;
                let userAnswer1;
                let userAnswer2;

                if (boxes2[0].textContent === '-') {
                    userInput0 = Number(boxes[0].textContent) * -1;
                } else {
                    userInput0 = Number(boxes[0].textContent);
                }
                userAnswer0 = Number((answers[0].textContent).replace('+', ''));

                if (boxes2[1].textContent === '-') {
                    userInput1 = Number(boxes[1].textContent) * -1;
                } else {
                    userInput1 = Number(boxes[1].textContent);
                }
                userAnswer1 = Number((answers[1].textContent).replace('+', ''));

                if (boxes2[2].textContent === '-') {
                    userInput2 = Number(boxes[2].textContent) * -1;
                } else {
                    userInput2 = Number(boxes[2].textContent);
                }
                userAnswer2 = Number((answers[2].textContent).replace('+', ''));

                if (userInput0 === userAnswer0 && userInput1 === userAnswer2 && userInput2 === userAnswer1) {
                    checkResult = true;
                }
            }
        }

        if (checkResult === true) {
            questionCorrect.textContent = (Number(questionCorrect.textContent) + 1).toString();
            formCorrect.value = questionCorrect.textContent;
            formCorrect2.value = questionCorrect.textContent;
            imgCorrect.style.display = 'block';
            imgCorrect.animate(displayImg, options2);

            document.querySelector('.param_feedback_input').value = paramFeedback.textContent;
            document.querySelector('.param_feedback_input2').value = paramFeedback.textContent;

            if (questionCount.textContent === questionNumber.textContent) {
                finishTimeH.value = document.querySelector('.info_passed_time_h').textContent;
                finishTimeM.value = document.querySelector('.info_passed_time_m').textContent;
                finishTimeS.value = document.querySelector('.info_passed_time_s').textContent;
                document.querySelector('.info_passed_time_h_result').textContent = document.querySelector('.info_passed_time_h').textContent;
                document.querySelector('.info_passed_time_m_result').textContent = document.querySelector('.info_passed_time_m').textContent;
                document.querySelector('.info_passed_time_s_result').textContent = document.querySelector('.info_passed_time_s').textContent;
                timeArea.style.display = 'none';
                timeArea2.style.display = 'flex';
            }
        } else {
            imgIncorrect.style.display = 'block';
            imgIncorrect.animate(displayImg, options2);

            setTimeout(()=>{ displayAnswer() }, 250);

            document.querySelector('.param_feedback_input').value = (paramFeedback.textContent + 'F' + infoFeedback.textContent);
            document.querySelector('.param_feedback_input2').value = (paramFeedback.textContent + 'F' + infoFeedback.textContent);

            if (questionCount.textContent === questionNumber.textContent) {
                finishTimeH.value = document.querySelector('.info_passed_time_h').textContent;
                finishTimeM.value = document.querySelector('.info_passed_time_m').textContent;
                finishTimeS.value = document.querySelector('.info_passed_time_s').textContent;
                document.querySelector('.info_passed_time_h_result').textContent = document.querySelector('.info_passed_time_h').textContent;
                document.querySelector('.info_passed_time_m_result').textContent = document.querySelector('.info_passed_time_m').textContent;
                document.querySelector('.info_passed_time_s_result').textContent = document.querySelector('.info_passed_time_s').textContent;
                timeArea.style.display = 'none';
                timeArea2.style.display = 'flex';
            }
        }
    });

    buttonPass.addEventListener('click', () => {
        buttonNext.style.pointerEvents = 'none';
        buttonBack.style.pointerEvents = 'none';
        buttonReset.style.pointerEvents = 'none';
        buttonCheck.style.pointerEvents = 'none';
        buttonPass.style.pointerEvents = 'none';
        buttonChange.style.pointerEvents = 'auto';
        buttonResult.style.pointerEvents = 'auto';
        buttonCheck.style.backgroundColor = 'gray';
        buttonPass.style.backgroundColor = 'gray';
        buttonChange.style.backgroundColor = 'rgb(0, 149, 224)';
        buttonResult.style.backgroundColor = 'rgb(0, 149, 224)';
        for (let i = 0; i < 12; i++) {
            buttonsInput[i].style.pointerEvents = 'none';
        }
        for (let i = 0; i < Number(answerCount.textContent); i++) {
            boxes6[i].style.pointerEvents = 'none';
        }
        imgPass.style.display = 'block';
        imgPass.animate(displayImg, options2);

        setTimeout(()=>{ displayAnswer() }, 250);

        document.querySelector('.param_feedback_input').value = paramFeedback.textContent + 'F' + infoFeedback.textContent;
        document.querySelector('.param_feedback_input2').value = paramFeedback.textContent + 'F' + infoFeedback.textContent;

        if (questionCount.textContent === questionNumber.textContent) {
            finishTimeH.value = document.querySelector('.info_passed_time_h').textContent;
            finishTimeM.value = document.querySelector('.info_passed_time_m').textContent;
            finishTimeS.value = document.querySelector('.info_passed_time_s').textContent;
            document.querySelector('.info_passed_time_h_result').textContent = document.querySelector('.info_passed_time_h').textContent;
            document.querySelector('.info_passed_time_m_result').textContent = document.querySelector('.info_passed_time_m').textContent;
            document.querySelector('.info_passed_time_s_result').textContent = document.querySelector('.info_passed_time_s').textContent;
            timeArea.style.display = 'none';
            timeArea2.style.display = 'flex';
        }
    });
});
