document.addEventListener('DOMContentLoaded', () => {
    // formタグを取得
    // 対象：class="form" or class="form2"
    // ボタンを押す（送信する）と無効化されるプログラム
    const formList = Array.from(document.querySelectorAll('.form, .form2'));

    // クリックされたボタンの識別
    let clickedButton = null;

    // form
    for (let i = 0; i < formList.length; i++) {
        // 対象form内のsubmitボタンを取得
        const buttons = Array.from(formList[i].querySelectorAll('button[type="submit"], input[type="submit"]'));
        for (let j = 0; j < buttons.length; j++) {
            buttons[j].addEventListener('click', () => {
                clickedButton = buttons[j];
            });
        }
        // 無効化とスタイル変更
        formList[i].addEventListener('submit', () => {
            if (clickedButton && formList[i].contains(clickedButton)) {
                // ボタンの無効化
                clickedButton.disabled = true;
            }
            for (let j = 0; j < buttons.length; j++) {
                buttons[j].disabled = true;
            }
        });
        clickedButton = null;
    }
});
