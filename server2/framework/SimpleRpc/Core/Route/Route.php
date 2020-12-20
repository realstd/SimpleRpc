<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 11:00 上午
 */

namespace SimpleRpc\Core\Route;

class Route
{
    private static $route;
    private static $instance;
    private function __construct()
    {
    }

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *
     * 添加一个路由
     *
     * @param $routeMethod
     * @param $routeRow
     */
    public function addRoute($routeMethod, $routeRow) {
        /**
         * 定义格式,用来与request中获取的路由信息匹配后分发：
         *
         * GET =>[
         *          [
         *              'routePath' => '/index/index',                  //路由地址
         *              'handel'    => 'App/Api/IndexController@index'  //要做什么
         *          ]
         * ]
         */
        self::$route[$routeMethod][] = $routeRow;
    }

    /**
     * 路由分发
     * @param $requestMethod
     * @param $pathInfo
     */
    public function dispatch($requestMethod,$pathInfo) {
        switch ($requestMethod) {
            case 'GET':
                if(!empty(self::$route[$requestMethod])) {
                    foreach(self::$route[$requestMethod] as $val) {
                        //判断当前路径是否注册路由
                        if($pathInfo == $val['routePath']) {
                            list($class,$method) = explode('@',$val['handle']);

                            return (new $class)->$method();
                        }
                    }
                }
                break;
            case 'POST':

        }
    }
}