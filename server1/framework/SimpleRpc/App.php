<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 9:18 上午
 */

namespace SimpleRpc;
use SimpleRpc\Core\Bean\BeanFactory;
use SimpleRpc\Core\Http\Server;


class App
{
    protected $beanFile = 'Bean.php';
    public function run($argv) {
        try {
            //初始化
            $this->init();
            //运行不同服务
            switch($argv[1]) {
                case 'http:start':
                    (new Server())->run();
                    break;
                case 'rpc:start';
                    (new \SimpleRpc\Core\Rpc\Server())->run();
                    break;
            }
        }catch (\Exception $e) {
            echo "FILE:".$e->getFile()."  Line:".$e->getLine()."  Message:".$e->getMessage().PHP_EOL;
        }catch (\Throwable $e) {
            echo "FILE:".$e->getFile()."  Line:".$e->getLine()."  Message:".$e->getMessage().PHP_EOL;
        }
    }

    /**
     * 初始化
     */
    public function init() {
        /*声明常量*/

        //根目录
        define('ROOT_PATH',dirname(dirname(__DIR__)));
        //应用程序目录
        define('APP_PATH',ROOT_PATH.'/application');
        //配置文件目录
        define('CONFIG_PATH',ROOT_PATH.'/config');

        //加载类容器
        $bean = require APP_PATH."/{$this->beanFile}";

        foreach($bean as $key => $val ) {
            BeanFactory::set($key,$val);
        }
    }


}