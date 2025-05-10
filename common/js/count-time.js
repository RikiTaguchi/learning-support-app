document.addEventListener('DOMContentLoaded', () => {
    const infoStartTime = Number(document.querySelector('.info_start_time').textContent) * 1000;
    const infoPassedTime = document.querySelector('.info_passed_time');
    const infoPassedTimeH = document.querySelector('.info_passed_time_h');
    const infoPassedTimeM = document.querySelector('.info_passed_time_m');
    const infoPassedTimeS = document.querySelector('.info_passed_time_s');
    const currentTimeH = document.querySelector('.passed_time_h');
    const currentTimeM = document.querySelector('.passed_time_m');
    const currentTimeS = document.querySelector('.passed_time_s');
    let infoCurrentTime;
    let timeData;
    let timeH;
    let timeM;
    let timeS;
    let timeDataNext;
    let timeHNext;
    let timeMNext;
    let timeSNext;
    

    setInterval(() => {
        infoCurrentTime = new Date();
        infoPassedTime.textContent = (Math.floor((infoCurrentTime.getTime() - infoStartTime)/1000)).toString();
        timeData = Number(infoPassedTime.textContent);
        timeH = Math.floor(timeData / (60 * 60));
        timeM = Math.floor((timeData - timeH) / 60);
        timeS = timeData - (timeH * 60 * 60) - (timeM * 60);
        infoPassedTimeH.textContent = timeH.toString().padStart(2, '0');
        infoPassedTimeM.textContent = timeM.toString().padStart(2, '0');
        infoPassedTimeS.textContent = timeS.toString().padStart(2, '0');
        timeDataNext = timeData + 1;
        timeHNext = Math.floor(timeDataNext / (60 * 60));
        timeMNext = Math.floor((timeDataNext - timeHNext) / 60);
        timeSNext = timeDataNext - (timeHNext * 60 * 60) - (timeMNext * 60);
        currentTimeH.value = timeHNext.toString().padStart(2, '0');
        currentTimeM.value = timeMNext.toString().padStart(2, '0');
        currentTimeS.value = timeSNext.toString().padStart(2, '0');
    }, 1000);
});
