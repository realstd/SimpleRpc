<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/18
 * Time          : 11:46 上午
 */
return [
    'Route'=>function(){
        return  \SimpleRpc\Core\Route\Route::getInstance(); //单例
    },
    'Config'=>function(){
        return  \SimpleRpc\Core\Config::getInstance();
    },
    'Reload'=>function(){
        return  \SimpleRpc\Core\Reload::getInstance();
    }
];