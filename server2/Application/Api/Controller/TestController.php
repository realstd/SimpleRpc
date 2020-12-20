<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 9:06 上午
 */

namespace App\Api\Controller;

/**
 * Class TestController
 * @package App\Api\Controller
 * @Controller (prefix="test")
 */
class TestController
{
    /**
     * @RequestMapping (route="info",method="get")
     */
    public function info() {
        return  "Welcome to test/info!";
    }
}