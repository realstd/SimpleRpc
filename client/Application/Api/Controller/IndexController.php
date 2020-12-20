<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 9:06 上午
 */

namespace App\Api\Controller;

/**
 * Class IndexController
 * @package App\Api\Controller
 * @Controller (prefix="index")
 */
class IndexController
{
    /**
     * @RequestMapping (route="index",method="get")
     */
    public function index() {
        return  "Wow ~ Successful route to index!";
    }
}