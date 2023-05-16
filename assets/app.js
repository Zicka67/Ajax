import './styles/app.css';

import './styles/bootstrap.min.css'; 

const formVideo = document.querySelector('#form_video');
const videosList = document.querySelector('#videos_list');


formVideo.addEventListener('submit', function (e) {
    e.preventDefault();

   
    // Effectue une requête POST vers l'URL spécifiée dans action du formulaire
    fetch(this.action, {
        body: new FormData(e.target),  // Récupère les données du formulaire
        method: 'POST'
    })
        .then(response => response.json())  // Convertit la réponse en JSON
        .then(json => {
            // console.log(json); 
            handleResponse(json);  // Appelle "handleResponse" en lui passant la réponse JSON
        })
        .catch(e => {
            console.error('problème avec: ' + e.message);
        });
});

const handleResponse = function (response) {
    // console.log('Handling response', response); 

    switch(response.code) {
        case 'VIDEO_ADDED_SUCCESSFULLY':
            videosList.insertAdjacentHTML('beforeend', response.html);  // Insère le HTML de la réponse à la fin de la liste de vidéos
            break;
    }
}