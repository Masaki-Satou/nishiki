// async function fetchWithDeviceId(url, options = {}) {
//     const deviceId = localStorage.getItem('device_id') || generateDeviceId();
//     localStorage.setItem('device_id', deviceId);

//     options.headers = {
//         ...options.headers,
//         'Device-ID': deviceId,
//     };

//     const response = await fetch(url, options);
//     return response.json();
// }

// function generateDeviceId() {
//     // デバイスIDを生成するロジック
//     // ここでは簡単なランダムIDを使用しますが、デバイス固有のIDを使うことを推奨します
//     return 'device-' + Math.random().toString(36).substr(2, 9);
// }

// // 使用例
// fetchWithDeviceId('/')
//     .then(data => console.log(data))
//     .catch(error => console.error('Error:', error));





setTimeout(function(){
    let toast=document.querySelector(".toast");
    if(toast){
        toast.classList.toggle('hidden2');
    }
},2000);