document.addEventListener('DOMContentLoaded', () => {
    const detailButton = Array.from(document.getElementsByClassName('detail-button'));
    const infoDetail = Array.from(document.getElementsByClassName('info-detail'));
    const infoButton = Array.from(document.getElementsByClassName('info-button'));
    // const printButton = Array.from(document.getElementsByClassName('print-button'));

    for (let i = 0; i < detailButton.length; i++) {
        detailButton[i].addEventListener('click', () => {
            if (infoDetail[i].style.display === 'none' && infoButton[i].style.display === 'none') {
                infoDetail[i].style.display = 'table-row';
                infoButton[i].style.display = 'table-row';
            } else {
                infoDetail[i].style.display = 'none';
                infoButton[i].style.display = 'none';
            }
        });
    }
});
