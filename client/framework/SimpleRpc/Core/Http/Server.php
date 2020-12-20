<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 10:11 上午
 */

namespace SimpleRpc\Core\Http;

use SimpleRpc\Core\Bean\BeanFactory;

/**
 * Http服务
 * Class HttpServer
 * @package SimpleRpc\Core\Http
 */
class Server extends \SimpleRpc\Core\Server
{
    protected $swooleServer;

    public function createServer()
    {
        $config = BeanFactory::get('config')->get('http');

        $this->swooleServer = new \Swoole\Http\Server($config['host'],$config['port']);

        //是否连带启动rpc服务
        if (isset($config['rpcEnable']) && (int)$config['rpcEnable']===1){
            (new \SimpleRpc\Core\Rpc\Server())->listen($this->swooleServer);
        }
    }

    public function initEvent()
    {
        $this->setEvent('sub',[
            'request' => 'onRequest',
        ]);
    }

    public function onStart()
    {
        $this->initStart();
        $config = $this->getConfig('http');
        echo "***********************************************************************" . PHP_EOL;
        echo sprintf("*HTTP     | Listen: %s:%d, type: TCP, worker: %d  ",
                $config['host'], $config['port'], $config['setting']['worker_num']) . PHP_EOL;
        if (isset($config['rpcEnable']) && (int)$config['rpcEnable']===1){
            $config = BeanFactory::get('Config')->get("rpc");
            echo sprintf("*RPC      | Listen: %s:%d, type: TCP, worker: %d  ",
                    $config['host'],$config['port'],$config['setting']['worker_num']).PHP_EOL;
            echo "***********************************************************************" . PHP_EOL;
        }
    }
    public function onRequest($request, $response) {
        //分发路由
        $res = BeanFactory::get('route')->dispatch($request->server['request_method'],$request->server['path_info']);
        $response->end($res);
    }
}