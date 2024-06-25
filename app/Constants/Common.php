<?php

namespace App\Constants;

class Common{

    const SHIPPING_FREE=10000;
    
    const GUEST_HOUR=3;//seeesionsテーブルのlast_activityから60*60*ここの数字をかけた時間が経過している
    
    const PRODUCT_ADD='1';
    const PRODUCT_REDUCE='2';

    const PRODUCT_LIST=[
        'add'=>self::PRODUCT_ADD,
        'reduce'=>self::PRODUCT_REDUCE,
    ];
}