export default class CardSwipe {
    constructor(containerElement, cardElement, feedbackElement, threshold) {
        this.container = document.getElementById(containerElement);
        this.card = cardElement;
        this.feedback = document.getElementById(feedbackElement);
        this.threshold = threshold;
        this.dragBound = this.drag.bind(this);
        this.stopDragBound = this.stopDrag.bind(this);

        this.startX = 0;
        this.startY = 0;
        this.isDragging = false;
        this.action = null;

        this.initEventListeners();
    }

    initEventListeners() {
        this.card.addEventListener('mousedown', this.startDrag.bind(this));
        this.card.addEventListener('touchstart', this.startDrag.bind(this));
        this.card.addEventListener('transitionend', this.removeResetClass.bind(this));
        if (this.feedback) {
            ['ignore', 'view', 'play'].forEach(action => {
                if (this.feedback.querySelector(`#${action}`)) {
                    this.feedback.querySelector(`#${action}`).addEventListener('click', this[action].bind(this));
                }
            });
        }
    }

    startDrag(e) {
        e.preventDefault();

        const currentTag = e.target
        if (currentTag.tagName.toLowerCase() === 'i') {
            if (currentTag.parentNode.tagName.toLowerCase() === 'span') {
                if (currentTag.parentNode.parentNode.tagName.toLowerCase() === 'a') {
                    currentTag.parentNode.parentNode.click();
                    return;
                }
            }
        } else if (currentTag.tagName.toLowerCase() === 'a') {
            currentTag.click();
            return;
        }

        this.isDragging = true;

        if (e.type === 'mousedown') {
            this.startX = e.clientX;
            this.startY = e.clientY;
        } else if (e.type === 'touchstart') {
            this.startX = e.touches[0].clientX;
            this.startY = e.touches[0].clientY;
        }

        this.card.classList.add('dragging');
        this.card.style.touchAction = 'pan-y';

        document.addEventListener('mousemove', this.dragBound);
        document.addEventListener('touchmove', this.dragBound);
        document.addEventListener('mouseup', this.stopDragBound);
        document.addEventListener('touchend', this.stopDragBound);
    }

    drag(e) {
        if (!this.isDragging) return;

        let x = 0;
        let y = 0;

        if (e.type === 'mousemove') {
            x = e.clientX;
            y = e.clientY;
        } else if (e.type === 'touchmove') {
            x = e.touches[0].clientX;
            y = e.touches[0].clientY;
        }

        const dx = x - this.startX;
        const dy = y - this.startY;

        const isHorizontal = Math.abs(dx) > Math.abs(dy);

        this.container.style.overflow = 'hidden';
        this.card.style.transform = `translateX(${dx}px) rotate(${dx / 60}deg)`;

        if (dx > this.threshold * this.container.offsetWidth) {
            if (this.feedback) {
                if (this.feedback.querySelector('#play')) {
                    this.feedback.querySelector('#play').classList.add('active');
                }
            }
            this.action = 'play';
            this.card.classList.remove('swipe-left', 'swipe-up');
            this.card.classList.add('swipe-right');
        } else if (dx < -this.threshold * this.container.offsetWidth) {
            if (this.feedback) {
                if (this.feedback.querySelector('#ignore')) {
                    this.feedback.querySelector('#ignore').classList.add('active');
                }
            }
            this.action = 'ignore';
            this.card.classList.remove('swipe-right', 'swipe-up');
            this.card.classList.add('swipe-left');
        } else {
            this.card.classList.remove('swipe-right', 'swipe-left', 'swipe-up');
            this.action = null;
            if (this.feedback) {
                if (this.feedback.querySelector('#play')) {
                    this.feedback.querySelector('#play').classList.remove('active');
                }
                if (this.feedback.querySelector('#ignore')) {
                    this.feedback.querySelector('#ignore').classList.remove('active');
                }
            }
        }

        if (
            !isHorizontal &&
            dy < 0 &&
            Math.abs(dx) <= this.threshold * this.container.offsetWidth
        ) {
            if (!this.playOnly) {
                if (this.feedback) {
                    if (this.feedback.querySelector('#view')) {
                        this.feedback.querySelector('#view').classList.add('active');
                    }
                }
                this.action = 'view';
                this.card.style.transform = `translateY(${dy}px)`;
                this.card.classList.remove('swipe-right', 'swipe-left');
                this.card.classList.add('swipe-up');
            } else {
                this.container.style.overflow = 'hidden';
                this.card.style.transform = `none`;
            }
        } else {
            if (this.feedback) {
                if (this.feedback.querySelector('#view')) {
                    this.feedback.querySelector('#view').classList.remove('active');
                }
            }
        }
    }

    stopDrag(e) {
        if (!this.isDragging) return;

        this.isDragging = false;

        this.card.classList.remove('dragging');
        this.card.style.touchAction = '';

        if (
            this.card.classList.contains('swipe-right') ||
            this.card.classList.contains('swipe-left') ||
            this.card.classList.contains('swipe-up')
        ) {
            this.card.style.transform = '';
            switch (this.action) {
                case 'ignore':
                    this.ignore();
                    break;
                case 'view':
                    this.view();
                    break;
                case 'play':
                    this.play();
                    break;
                default:
                    break;
            }
        } else {
            this.card.style.transition = 'transform 0.3s';
            this.card.style.transform = '';
            setTimeout(() => {
                this.card.style.transition = '';
            }, 300);
            if (this.feedback) {
                if (this.feedback.querySelector('#ignore')) {
                    this.feedback.querySelector('#ignore').classList.remove('active');
                }
                if (this.feedback.querySelector('#view')) {
                    this.feedback.querySelector('#view').classList.remove('active');
                }
                if (this.feedback.querySelector('#play')) {
                    this.feedback.querySelector('#play').classList.remove('active');
                }
            }
        }

        document.removeEventListener('mousemove', this.dragBound);
        document.removeEventListener('touchmove', this.dragBound);
    }

    removeResetClass() {
        this.card.classList.remove('reset');
        this.container.style.overflow = 'visible';
    }

    ignore(e) {
        if (this.feedback) {
            if (this.feedback.querySelector('#ignore')) {
                this.feedback.querySelector('#ignore').classList.add('active');
            }
        }
        this.container.style.overflow = 'hidden';
        this.card.classList.add('swipe-left');
        this.stopDrag(e);
        window.location.href = '/match/decision/' + this.card.dataset.id + '/cancel';
    }

    view(e) {
        if (this.feedback) {
            if (this.feedback.querySelector('#view')) {
                this.feedback.querySelector('#view').classList.add('active');
            }
        }
        this.card.classList.add('swipe-up');

        setTimeout(() => {
            this.card.style.transition = 'transform 0.3s';
            this.card.style.transform = 'translateY(0)';
            if (this.feedback) {
                if (this.feedback.querySelector('#ignore')) {
                    this.feedback.querySelector('#ignore').classList.remove('active');
                }
                if (this.feedback.querySelector('#view')) {
                    this.feedback.querySelector('#view').classList.remove('active');
                }
                if (this.feedback.querySelector('#play')) {
                    this.feedback.querySelector('#play').classList.remove('active');
                }
            }

            setTimeout(() => {
                this.card.style.transition = '';
                this.card.style.transform = '';
                this.card.classList.remove('swipe-up');
            }, 500);
        }, 500);

        this.stopDrag(e);
        window.location.href = '/hub/album/' + this.card.dataset.id;
    }

    play(e) {
        if (this.feedback) {
            if (this.feedback.querySelector('#play')) {
                this.feedback.querySelector('#play').classList.add('active');
            }
        }
        this.container.style.overflow = 'hidden';
        this.card.classList.add('swipe-right');
        this.stopDrag(e);
        window.location.href = '/match/decision/' + this.card.dataset.id + '/play';
    }
}
