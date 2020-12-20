<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 10:11 上午
 */

namespace SimpleRpc\Core\Rpc;

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
        $config = BeanFactory::get('config')->get('rpc');

        $this->swooleServer = new \Swoole\Server($config['host'],$config['port']);
    }

    public function initEvent()
    {
        $this->setEvent('sub',[
            'receive' => 'onReceive',
        ]);
    }

    public function onStart()
    {
        $this->initStart();
        $config = $this->getConfig('rpc');

        echo " *********************************************************************".PHP_EOL;
        echo sprintf("*RPC     | Listen: %s:%d, type: TCP, worker: %d  ",$config['host'],$config['port'],$config['setting']['worker_num']).PHP_EOL;
    }

    public function onReceive( $server, $fd, $reactor_id, $data) {
        $data = json_decode($data);
        var_dump($data);
    }

    public  function listen($server){
        $config = BeanFactory::get('Config')->get("rpc");
        $server->addlistener($config['host'], $config['port'],SWOOLE_SOCK_TCP);
        $server->set($config['setting']);
        $server->on('receive', [$this, 'onReceive']);
    }
}