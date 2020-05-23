/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import $ from 'jquery';
import '../css/app.css';
require ('select2')

$('select').select2()

//code pour masquer et afficher le boutton de contact
let $contactButton = $('#contactButton')
$contactButton.click(event => {
    event.preventDefault();
    $('#contactForm').slideDown();
    $contactButton.slideUp();
})


//suppression des elements (les images, .....)
document.querySelectorAll('[data-delete]').forEach(a =>{
    a.addEventListener('click', e => {
        e.preventDefault()
        fetch(a.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With' : 'XMLHttpRequest',
                'Content-type': 'application/json'
            },
            body: JSON.stringify({'_token': a.dataset.token})
        }).then(response => response.json())
          .then(data => {
              if(data.success){
                    a.parentNode.parentNode.removeChild(a.parentNode)
              }else{
                  alert(data.error)
              }
          })
          .catch(e => alert(e))
    })
})


// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
