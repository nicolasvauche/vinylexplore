import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        let lazyImages = [].slice.call(document.querySelectorAll("img.lazy-load"));
        let delay = 300;

        lazyImages.reduce((promise, lazyImage) => {
            return promise.then(() => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        lazyImage.src = lazyImage.dataset.src;
                        lazyImage.onload = function () {
                            this.style.display = 'block';
                        }
                        lazyImage.addEventListener('click', e => {
                            document.querySelectorAll('.app-covers input').forEach(elt => {
                                elt.checked = false
                                elt.parentNode.classList.remove('active');
                            })
                            if (!e.target.parentNode.querySelector('input').checked) {
                                e.target.parentNode.querySelector('input').checked = true;
                                e.target.parentNode.classList.add('active');
                            } else {
                                e.target.parentNode.querySelector('input').checked = false;
                                e.target.parentNode.classList.remove('active');
                            }
                        })
                        resolve();
                    }, delay);
                });
            });
        }, Promise.resolve());
    }
}
