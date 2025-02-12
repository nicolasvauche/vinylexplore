import {Controller} from '@hotwired/stimulus';
import CardSwipe from 'CardSwipe';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        const card = document.getElementById('swipable')
        if (card) {
            const cardSwipe = new CardSwipe('swiper', card, 'feedback', 0.3)
        }
    }
}
