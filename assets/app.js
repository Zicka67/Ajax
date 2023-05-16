import './styles/app.css';

import './styles/bootstrap.min.css'; 

const formVideo = document.querySelector('#form_video');
const videosList = document.querySelector('#videos_list');


formVideo.addEventListener('submit', function (e) {
    e.preventDefault();

    fetch(this.action, {
        body: new FormData(e.target),
        method: 'POST'
    })
        .then(response => response.json())
        .then(json => {
            handleResponse(json);
        });
});