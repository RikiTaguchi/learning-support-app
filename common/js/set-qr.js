const video = document.getElementById('video');
let contentWidth;
let contentHeight;

let infoWidth = 0;
let infoHeight = 0;
let infoCamera;
if (window.matchMedia('(max-width: 1024px)').matches) {
   infoWidth = window.innerHeight;
   infoHeight = window.innerWidth;
   infoCamera = {exact: "environment"};
} else {
   infoWidth = window.innerWidth;
   infoHeight = window.innerHeight;
   infoCamera = "user";
}

const media = navigator.mediaDevices.getUserMedia({ audio: false, video: {width: infoWidth, height: infoHeight, facingMode: infoCamera} })
   .then((stream) => {
      video.srcObject = stream;
      video.onloadeddata = () => {
         video.play();
         contentWidth = video.clientWidth;
         contentHeight = video.clientHeight;
         canvasUpdate();
         checkImage();
      }
   }).catch((e) => {
      console.log(e);
   });

const cvs = document.getElementById('camera-canvas');
const ctx = cvs.getContext('2d');
const canvasUpdate = () => {
   cvs.width = contentWidth;
   cvs.height = contentHeight;
   ctx.drawImage(video, 0, 0, contentWidth, contentHeight);
   requestAnimationFrame(canvasUpdate);
}

const rectCvs = document.getElementById('rect-canvas');
const rectCtx =  rectCvs.getContext('2d');
const previewArea = document.querySelector('#main-inner-form-area');
const previewButton = document.querySelector('.main-form-qr-button');
const previewBackButton = document.querySelector('.main-form-qr-button-back');
const previewImage = document.querySelector('.main-form-qr-preview');

let isSubmitting = false;

const previewImage0 = document.querySelector('.main-form-qr-preview-0');
const previewImageList = document.querySelector('.main-form-qr-preview-list');

const previewSubmit = document.querySelector('.main-form-qr');
const cameraBackButton = document.querySelector('.main-form-back-button');
const options = {
   duration: 500,
   easing: 'ease',
   fill: 'forwards',
};
const previewOpen = {
   translate: ['0 0', '0 100vh'],
};
const previewClose = {
   translate: ['0 100vh', '0 0'],
};
const checkImage = () => {
   const imageData = ctx.getImageData(0, 0, contentWidth, contentHeight);
   const code = jsQR(imageData.data, contentWidth, contentHeight);

   if (code) {
      drawRect(code.location);

      // 正規表現の定義
      let pattern1;
      let pattern2;

      if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
         // ローカル環境
         pattern1 = /^http:\/\/localhost\/learning-support-app\/e\/get_stamp.php\?table_id=[0-9]{6}&img_id=[0-9]{6}&img_extention=.+$/g;
         pattern2 = /^http:\/\/localhost\/learning-support-app\/e\/get_stamp.php\?table_id=[0-9]{6}&img_id=[0-9]{6}&img_extention_0=.+$/g;
      } else {
         // 本番環境
         pattern1 = /^https:\/\/wordsystemforstudents.com\/e\/get_stamp.php\?table_id=[0-9]{6}&img_id=[0-9]{6}&img_extention=.+$/g;
         pattern2 = /^https:\/\/wordsystemforstudents.com\/e\/get_stamp.php\?table_id=[0-9]{6}&img_id=[0-9]{6}&img_extention_0=.+$/g;
      }
      
      if (pattern1.test(code.data) === true && previewButton.style.display === 'none' && previewBackButton.style.display === 'none') {
         let infoQR = (code.data).split('?')[1].split('&');
         let tableId = infoQR[0].split('=')[1];
         let imgId = infoQR[1].split('=')[1];
         let imgExtention = infoQR[2].split('=')[1];
         let imgName = tableId + '_' + imgId + '.' + imgExtention;
         previewButton.style.display = 'flex';
         previewBackButton.style.display = 'block';
         previewImage.src = '../common/stamp/' + imgName;
         previewSubmit.action = code.data;
         cameraBackButton.style.display = 'none';
         previewImage0.style.display = 'none';
         previewImageList.style.display = 'none';
         previewImage.style.display = 'block';
         previewArea.animate(previewOpen, options);
      }

      else if (pattern2.test(code.data) === true && previewButton.style.display === 'none' && previewBackButton.style.display === 'none') {
         previewImage0.style.display = 'block';
         previewButton.style.display = 'flex';
         previewBackButton.style.display = 'block';
         previewSubmit.action = code.data;
         cameraBackButton.style.display = 'none';
         previewImageList.style.display = 'block';
         previewImage.style.display = 'none';
         previewArea.animate(previewOpen, options);
      }

   } else {
      rectCtx.clearRect(0, 0, contentWidth, contentHeight);
   }

   previewBackButton.addEventListener('click', () => {
      previewBackButton.style.pointerEvents = 'none';
      previewArea.animate(previewClose, options);
      const setDisplay = () => {
         previewButton.style.display = 'none';
         previewImage.src = '../common/images/non.png';
         previewSubmit.action = '';
         cameraBackButton.style.display = 'block';
         previewImageList.style.display = 'none';
         previewImage.style.display = 'none';
         previewImage0.style.display = 'none';
         previewBackButton.style.display = 'none';
         previewBackButton.style.pointerEvents = 'auto';

         // 取得ボタンを有効にする
         previewButton.disabled = false;
         isSubmitting = false;
      }
      setTimeout(()=>{ setDisplay() }, 500);
   });

   setTimeout(()=>{ checkImage() }, 500);
}

const drawRect = (location) => {
   rectCvs.width = contentWidth;
   rectCvs.height = contentHeight;
   drawLine(location.topLeftCorner, location.topRightCorner);
   drawLine(location.topRightCorner, location.bottomRightCorner);
   drawLine(location.bottomRightCorner, location.bottomLeftCorner);
   drawLine(location.bottomLeftCorner, location.topLeftCorner)
}

const drawLine = (begin, end) => {
   rectCtx.lineWidth = 4;
   rectCtx.strokeStyle = "#F00";
   rectCtx.beginPath();
   rectCtx.moveTo(begin.x, begin.y);
   rectCtx.lineTo(end.x, end.y);
   rectCtx.stroke();
}

// 取得ボタンを無効にする
previewSubmit.addEventListener('submit', (e) => {
   if (isSubmitting) {
      e.preventDefault();
      return;
   }
   isSubmitting = true;
   previewButton.disabled = true;
});
