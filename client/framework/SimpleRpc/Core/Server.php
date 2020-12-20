<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/17
 * Time          : 10:11 上午
 */

namespace SimpleRpc\Core;

use SimpleRpc\Core\Annotation\Parse;
use SimpleRpc\Core\Bean\BeanFactory;
use Swoole\Exception;
use Swoole\Server as SwooleServer;

/**
 * Server服务
 * Class Server
 * @package SimpleRpc\Core
 */
abstract class Server
{
    protected $swooleServer;
    /**
     * 因为服务需要自定义回调函数
     *
     * @var array
     */
    protected $event = [
        // 这是所有服务均会注册的
        'server'=>[
            // 事件   =》 事件函数
            "start"        => "onStart",
            "managerStart" => "onManagerStart",
            "managerStop"  => "onManagerStop",
            "shutdown"     => "onShutdown",
            "workerStart"  => "onWorkerStart",
            "workerStop"   => "onWorkerStop",
            "workerError"  => "onWorkerError",
        ],
        //子类服务的时间
        'sub'=>[

        ],
    ];
    /**
     * 初始化监听的事件
     */
    protected abstract function initEvent();

    /**
     * 创建服务
     */
    protected abstract function createServer();

    public function run()
    {
        //加载配置
        BeanFactory::get('config')->load();

        echo BeanFactory::get('config')->get('startSign');

        //创建swoole server
        $this->createServer();

        //设置需要注册的回调函数
        $this->initEvent();

        //设置swoole的回调函数
        $this->setSwooleEvent();

        //启动服务
        $this->swooleServer->start();
    }


    /**
     * 设置swoole的回调事件
     */
    protected function setSwooleEvent()
    {
        foreach ($this->event as $type => $events) {
            foreach ($events as $event => $func) {
                $this->swooleServer->on($event, [$this, $func]);
            }
        }
    }

    public function setEvent($type,$event)
    {
        // 暂时不支持直接设置系统的回调事件
        if ($type == "server") {
            return $this;
        }
        $this->event[$type] = $event;
        return $this;
    }

    public function onStart()
    {
        $this->initStart();
    }

    public function initStart()
    {
        $reload             = BeanFactory::get('reload');
        $reload->watchFile  = [ROOT_PATH];
        $reload->md5Flag    = $reload->getMd5();

        //定时监控重新加载
        \Swoole\Timer::tick(3000,function () use($reload){
            if($reload->reload()) {
                $this->swooleServer->reload();
            }
        });
    }

    public function getConfig($name) {
        return BeanFactory::get('Config')->get($name);
    }

    public function onManagerStart(SwooleServer $server)
    {

    }
    public function onManagerStop(SwooleServer $server)
    {

    }
    public function onShutdown(SwooleServer $server)
    {

    }
    public function onWorkerStart(SwooleServer $server, int $worker_id)
    {
        //载入路由注解
        try {
            (new Parse())->loadAnnotations();
        } catch (\ReflectionException $e) {
        }

    }
    public function onWorkerStop(SwooleServer $server, int $worker_id)
    {

    }
    public function onWorkerError(SwooleServer $server, int $workerId, int $workerPid, int $exitCode, int $signal)
    {

    }
}