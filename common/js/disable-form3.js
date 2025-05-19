document.addEventListener('DOMContentLoaded', () => {
    const formList = Array.from(document.getElementsByClassName('form4'));
    const buttonList = Array.from(document.getElementsByClassName('form-button-set'));
    let clickedButton = null;
    for (let i = 0; i < formList.length; i++) {
        for (let j = 0; j < buttonList.length; j++) {
            buttonList[j].addEventListener('click', () => {
                clickedButton = buttonList[j];
            });
        }
        formList[i].addEventListener('submit', () => {
            const url = new URL(formList[i].action, window.location.origin);
            url.searchParams.append('submit_order', clickedButton.value);
            formList[i].action = url.toString();
            clickedButton.disabled = true;
        });
        clickedButton = null;
    }
});
