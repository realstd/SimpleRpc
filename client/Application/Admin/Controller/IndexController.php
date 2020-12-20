<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 9:06 上午
 */

namespace App\Admin\Controller;

use SimpleRpc\Core\Rpc\Client;

/**
 * Class IndexController
 * @package App\Api\Controller
 * @Controller (prefix="admin")
 */
class IndexController
{
    /**
     * @RequestMapping (route="index",method="get")
     */
    public function index() {

        $client = new Client();
        //模拟rpc调用
        $goodsRes = $client->service('GoodsService')->list(['test']);
        $goodsList = json_decode($goodsRes,true)['data'];

        //模拟rpc调用
        $orderV1Res = $client->service('OrderService')->version('1.0')->list(['test']);
        $orderListV1 = json_decode($orderV1Res,true)['data'];

        //模拟rpc调用
        $orderV2Res = $client->service('OrderService')->version('2.0')->list(['test']);
        $orderListV2 = json_decode($orderV2Res,true)['data'];

        return json_encode(['goodList'=>$goodsList,'orderListV1'=>$orderListV1,'orderListV2'=>$orderListV2]);
    }
}