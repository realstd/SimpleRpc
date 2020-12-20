<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/18
 * Time          : 2:05 下午
 */

return [
    'GoodsService_1.0' => [
        'host' => '127.0.0.1',
        'port' => 8001,
        'rpcEnable'=>1, //启动rpc
        'setting'=>[
            'worker_num'=>2
        ]
    ],
    'OrderService_1.0' => [
        'host' => '127.0.0.1',
        'port' => 8002,
        'setting'=>[
            'worker_num'=>2
        ]
    ],
    'OrderService_2.0' => [
        'host' => '127.0.0.1',
        'port' => 8002,
        'setting'=>[
            'worker_num'=>2
        ]
    ],

];