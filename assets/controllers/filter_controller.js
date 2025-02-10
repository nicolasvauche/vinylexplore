import {Controller} from '@hotwired/stimulus'

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        this.filterContainer = document.querySelector('.app-main .app-section .app-filters');
        this.triggerElement = this.element;

        document.addEventListener('click', this.closeOnClickOutside.bind(this));
    }

    disconnect() {
        document.removeEventListener('click', this.closeOnClickOutside.bind(this));
    }

    toggle(e) {
        e.preventDefault();

        if (this.filterContainer.classList.contains('open')) {
            this.filterContainer.classList.remove('open');
            this.triggerElement.classList.remove('active');
        } else {
            this.filterContainer.classList.add('open');
            this.triggerElement.classList.add('active');
        }
    }

    closeOnClickOutside(e) {
        if (
            this.filterContainer &&
            !this.filterContainer.contains(e.target) &&
            !this.triggerElement.contains(e.target)
        ) {
            this.filterContainer.classList.remove('open');
            this.triggerElement.classList.remove('active');
        }
    }
}
