class Contact {

    _observers = [];
   

    _op={
        // Optional parameters
        // direction: 'vertical',
        loop: true,
        grabCursor: true,
        // spaceBetween:10,
        effect: 'slide',//fade,slide,coverflow,cube,flip
        centeredSlides: true,
        slidesPerView:1.5,
        speed: 2500,
        
        breakpoints:{
            1024:{
                slidesPerView: 3.5,

            },
        },

        pagination: {
            el: '.swiper-pagination', //ページネーションの要素
            type: 'bullets', //ページネーションの種類
            clickable: true, //クリックに反応させる
        },
        navigation:{
            nextEl:'.swiper-button-next',
            prevEl:'.swiper-button-prev',
        },
    }

    constructor() {
        this._attensionSwiper=new HeroSlider('.attention-swiper',this._op);
        // this._infoSwiper=new HeroSlider('.info-swiper',this._op);
      
        // this._heroels.forEach(e=>this._heros.push(new HeroSlider('.'+e.classList[1],this._op)));
        this._init();
    }

    _init() {
        this._scrollInit();
    }

    destroy() {
        this._observers.forEach(so => so.destroy());
    }

    _scrollInit() {
        this._observers.push(
            new ScrollObserver('.attention-swiper', this._toggleSlideAnimation.bind(this), { once: false },this._attensionSwiper),
            // new ScrollObserver('.info-swiper', this._toggleSlideAnimation.bind(this), { once: false },this._infoSwiper)
        )
        
    }

    _toggleSlideAnimation(el, inview,hero) {
        if(inview) {
            hero.start( {delay: 5000});
        } else {
            hero.stop();
        }
    }
}

const item = new Contact;