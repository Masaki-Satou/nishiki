    
    let card=document.querySelector('#card');
    let bank=document.querySelector('#bank');
    let delivery=document.querySelector('#delivery');
    let bank_desc=document.querySelector('.payment_bank_desc');
    let card_desc=document.querySelector('.payment_card_desc');
    let delivery_desc=document.querySelector('.payment_delivery_desc');

    if(card){

        card.addEventListener('change',function(){
            bank_desc.style.display="block";
            card_desc.style.display="none";
            delivery_desc.style.display="none";
            // desc.innerText='※下記の「購入画面に進む」ボタンをクリック後、クレジットカード情報入力画面に移動します。';
        });
        bank.addEventListener('change',function(){
            bank_desc.style.display="none";
            card_desc.style.display="block";
            delivery_desc.style.display="none";
            // desc.innerText='※下記の「購入画面に進む」ボタンをクリック後、最終確認メッセージが表示され、「OK」をクリックするとご注文が確定されます。\n銀行振り込みは前払いとなり、ご入金確認後、手配致します。\n振込先：\n三井住友銀行　三田支店（サンダ）　店番391\n普通　9102605\n株式会社ロペ商事（ロペショウジ）\n※お振込み手数料はお客様負担にてお願い致します。\nなお、7日以内に入金確認が出来ない場合はキャンセルとさせていただきますのでご了承下さい。';
        });
        delivery.addEventListener('change',function(){
            bank_desc.style.display="none";
            card_desc.style.display="none";
            delivery_desc.style.display="block";
            // desc.innerText='※下記の「購入画面に進む」ボタンをクリック後、最終確認メッセージが表示され、「OK」をクリックするとご注文が確定されます。\n画面の合計金額に、ヤマト運輸（コレクト）便/代引手数料 300円がかかりますので、ご注意下さい。\n※税込5,000円以上お買い上げいただくと代引手数料は無料となります。';
        });
    }



    function checkoutPost(e){

        yes=document.querySelector('#yes');
        no=document.querySelector('#no');
        
        if(yes && no){
            if(yes.checked==false && no.checked==false){
                alert('初回購入時のみ、「常温商品」と「冷蔵商品」の同梱について　承諾する/承諾しない　を選択して下さい。');
                return;
            }
        }

        fom=document.querySelector('#checkout');
        zone=document.querySelector('.timezone');
        
        if(zone.value==1){
            if(confirm('お届け希望時間は「希望なし」で宜しいですか？')){
                if(bank.checked || delivery.checked){
                    if(confirm('購入を確定しますがよろしいですか？')){
                        fom.submit();     
                    }
                }else{
                    fom.submit();
                }
            }
        }else{
            if(bank.checked || delivery.checked){
                if(confirm('購入を確定しますがよろしいですか？')){
                    fom.submit();     
                }
            }else{
                fom.submit();
            }

        }
    }



    
    var positionY;					/* スクロール位置のY座標 */
    var STORAGE_KEY = "scrollY";	/* ローカルストレージキー */

    function update(e){
        //現在地を取得
        positionY = window.scrollY;
        localStorage.setItem(STORAGE_KEY, positionY);
    
        document.querySelector('#change_'+ e.dataset.id).submit();
    }

    function deletePost(e){
        if(confirm('本当に削除しますか？')){
            document.querySelector('#delete_' + e.dataset.id).submit();
        }
    }

    window.addEventListener("load", function(){
    // ストレージチェック
        positionY = localStorage.getItem(STORAGE_KEY);

        // 前回の保存データがあればスクロールする
        if(positionY !== null){
            scrollTo(0, positionY);
            localStorage.setItem(STORAGE_KEY, null);//スクロール位置を破棄

        }

    });



    // let deliHomeEl=document.querySelector('#deli_home');
    // let deliGiftEl=document.querySelector('#deli_gift');
    // let deliGiftFormEl=document.querySelector(".destination__inner");
    // let giftDescEl=document.querySelector(".gift-desc");
    // let homeTitleEl=document.querySelector(".home-title");

    // let giftNameEl=document.querySelector('.gift_name');
    // let giftPostCodeEl=document.querySelector('.gift_post_code');
    // let giftPrefectureIdEl=document.querySelector('.gift_prefecture');
    // let giftAddressEl=document.querySelector('.gift_address');
    // let giftTelEl=document.querySelector('.gift_tel');
    // let kaigyouEl=document.querySelector('.kaigyou');

    // //2つあるyazirusiの1つ目を取得する事になるので、destinationコンポーネント内のyazirusiを取得する事になる
    // let yazirusiEl=document.querySelector('.yazirusi');


    // window.addEventListener("load", function(){
    //     switchGiftForm();
    // });

    // deliHomeEl.addEventListener('change',function(){
    //     switchGiftForm();
    // })
    // deliGiftEl.addEventListener('change',function(){
    //     switchGiftForm();
    // })

    // function switchGiftForm(){
    //     if(deliHomeEl.checked){
    //         deliGiftFormEl.style.display='none';
    //         giftDescEl.style.display='none';
    //         homeTitleEl.innerHTML='【お届け先情報】';
    //         giftNameEl.required =false;
    //         giftPostCodeEl.required =false;
    //         giftPrefectureIdEl.required =false;
    //         giftAddressEl.required =false;
    //         giftTelEl.required =false;
    //         kaigyouEl.style.display='block';
    //         yazirusiEl.style.display='none';
    //     }else{
    //         deliGiftFormEl.style.display='block';
    //         giftDescEl.style.display='block';
    //         homeTitleEl.innerHTML='【送り主情報】';
    //         giftNameEl.required =true;
    //         giftPostCodeEl.required =true;
    //         giftPrefectureIdEl.required =true;
    //         giftAddressEl.required =true;
    //         giftTelEl.required =true;
    //         kaigyouEl.style.display='none';

    //         if(window.innerWidth<650){
    //             yazirusiEl.style.display='block';
    //         }
    //     }
    // }

    
    //数量変更後にchangeイベントで自動的に画面更新
    // nums=document.querySelectorAll('.number');
    // nums.forEach(e=>e.addEventListener('change',function(){
    //     document.querySelector('#change_'+ e.dataset.id).submit();
    // })
    // );


    //数量変更後にボタンクリック時に画面更新
    // function updatePost(e){
    //     num=document.querySelector('.number');
    //     if(num.value<1){
    //         alert('数量は1以上で入力して下さい。');
    //     }else{
    //         document.querySelector('#change_'+ e.dataset.id).submit();
    //     }
    // }
