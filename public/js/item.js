
class Item {

    _observers = [];
    _heroels=[];
    _heros=[];

    _op={
        // Optional parameters
        // direction: 'vertical',
        loop: true,
        grabCursor: true,
        effect: 'fade',//fade,slide,coverflow,cube,flip,creative
        centeredSlides: true,
        slidesPerView: 1,
        speed: 1500,
        
        // breakpoints:{
        //     1024:{
        //         slidesPerView: 2,

        //     },
        // },
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
        //class="swiper swiper-item[1～]"1つ目のクラス名で全て取得し、
        this._heroels=document.querySelectorAll('.swiper');
        //class="swiper swiper-item[1～]"2つ目のクラス名で識別する、
        this._heroels.forEach(e=>this._heros.push(new HeroSlider('.'+e.classList[1],this._op)));
        this._init();
    }

    _init() {
        this._scrollInit();
    }

    destroy() {
        this._observers.forEach(so => so.destroy());
    }

    _scrollInit() {

        for(let i=0;i<this._heroels.length;i++){
            this._observers.push(
                new ScrollObserver('.'+this._heroels[i].classList[1], this._toggleSlideAnimation.bind(this), { once: false },this._heros[i]),
            )
        }
    }

    _toggleSlideAnimation(el, inview,hero) {
        if(inview) {
            hero.start();
        } else {
            hero.stop();
        }
    }
}

const item = new Item;






//カートに追加された時は.cart-in　要素が表示されているので、同じ要素に付与されているvisibleクラスを消して、トランジションを発動しながら消す
cartin=document.querySelector('.cart-in');
if(cartin){
    let find=cartin.textContent.indexOf('カート');
    let delay=0;

    if(find>0){
        delay=2000;
    }else{
        delay=10000;
    }


    setTimeout(() => {
        cartin.classList.toggle('visible');
    }, delay);
};


var positionY;					/* スクロール位置のY座標 */
var STORAGE_KEY = "scrollY";	/* ローカルストレージキー */

/*
* checkOffset関数: 現在のスクロール量をチェックしてストレージに保存
*/
adds=document.querySelectorAll('.add');
adds.forEach(e=>e.addEventListener('click',checkOffset));

function checkOffset(){
    positionY = window.scrollY;
    localStorage.setItem(STORAGE_KEY, positionY);
}


/*
* 起動時の処理
*
*		ローカルストレージをチェックして前回のスクロール位置に戻す
*/
window.addEventListener("load", function(){
    // ストレージチェック
    positionY = localStorage.getItem(STORAGE_KEY);

    // 前回の保存データがあればスクロールする
    if(positionY !== null){
        scrollTo(0, positionY);
        localStorage.setItem(STORAGE_KEY, null);//スクロール位置を破棄

    }

    // スクロール時のイベント設定
    // window.addEventListener("scroll", checkOffset, false);
   
});
