/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

const likeButtons = document.querySelectorAll('.js-book-like')

likeButtons.forEach(element => {
    element.addEventListener('click', function (event) {
        jsLike(event)
    })
})

const jsLike = function (event) {
    event.preventDefault()
    let target = event.target;
    const href = target.href
    fetch(href)
        .then(function (response) {
            return response.json()
        })
        .then(function (json) {
            target.innerHTML = `${json.currentUserLikes ? 'Unlike' : 'Like'} (${json.nbLikes})`
        })
}
