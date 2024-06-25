class HeroSlider {
    constructor(el,op) {
        this.el = el;
        this.op=op;
        this.swiper = this._initSwiper();
    }

    _initSwiper(op) {
        return new Swiper(this.el,this.op);
    }

    start(options = {}) {
        options = Object.assign({
            delay: 4000,
            disableOnInteraction: false
        }, options);
        
        this.swiper.params.autoplay = options;
        this.swiper.autoplay.start();
    }
    stop() {
        this.swiper.autoplay.stop();
    }
}