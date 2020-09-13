// pour la géolocalisation
import Places from 'places.js'
// pour le chargement des cartes
import Map from './modules/map'
//pour créer un slider pour les images d'un bien
import 'slick-carousel'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'
// any CSS you import will output into a single css file (app.css in this case)
import $ from 'jquery';
import '../css/app.css';



Map.init()

//rechercher un bien avec une addresse
let inputAdress = document.querySelector('#property_address')
if (inputAdress !== null) {
    let place = Places({
        container: inputAdress
    })
    place.on('change', e =>{
        document.querySelector('#property_city').value = e.suggestion.city
        document.querySelector('#property_postal_code').value = e.suggestion.postcode
        document.querySelector('#property_lat').value = e.suggestion.latlng.lat
        document.querySelector('#property_lng').value = e.suggestion.latlng.lng
    })
}

//géolocalisation d'un bien
let searchAddress = document.querySelector('#search_address')
if (searchAddress !== null) {
    let place = Places({
        container: searchAddress
    })
    place.on('change', e => {
        document.querySelector('#lat').value = e.suggestion.latlng.lat
        document.querySelector('#lng').value = e.suggestion.latlng.lng
    })
}


//gérer les images avec la librairies
$('[data-slider]').slick({
    dots: true,
})

//implémenter un select sur les options des biens
require ('select2')
$('select').select2()

//code pour masquer et afficher le boutton de contact
let $contactButton = $('#contactButton')
$contactButton.click(event => {
    event.preventDefault();
    $('#contactForm').slideDown();
    $contactButton.slideUp();
})


// pour rendre les liens actifs
$(document).ready(function () {
function ONCLICK() {
    const currentLocalisation = location.href;
    const menuItem = document.querySelectorAll("a");
    const menuLength = menuItem.length;
    for (let i = 0; i < menuLength; i++) {
        if (menuItem[i].href === currentLocalisation) {
            menuItem[i].className = "active";
        }

    }
}
ONCLICK();
});


//suppression des elements (les images, .....)
document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        fetch(a.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-type': 'application/json'
            },
            body: JSON.stringify({ '_token': a.dataset.token })
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    a.parentNode.parentNode.removeChild(a.parentNode)
                } else {
                    alert(data.error)
                }
            })
            .catch(e => alert(e))
    })
})

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
