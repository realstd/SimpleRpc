<?php
/**
 * Author        : suntengda
 * Date          : 2020/12/19
 * Time          : 10:38 上午
 */

namespace SimpleRpc\Core\Rpc;


use SimpleRpc\Core\Bean\BeanFactory;

class Client
{
    protected $ip;
    protected $port;
    protected $serviceName;
    protected $version = '1.0';

    public function __call($name, $arguments)
    {
        //拦截版本号
        if($name == 'version') {
            $this->version = $arguments[0];
            //返回对象供链式调用
            return $this;
        }
        //拦截服务
        if($name == 'service') {
            $this->serviceName = $arguments[0];
            //返回对象供链式调用
            return $this;
        }

        //获取服务ip 和端口号
        $config = BeanFactory::get('config')->get(ucfirst($this->serviceName).'_'.$this->version);

        if(!empty($config)) {
            $this->ip = $config['host'];
            $this->port = $config['port'];
        }else {
            throw new \Exception("没有找到响应的服务，请核对");
        }

        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);
        $data = $this->jsonData($name,$arguments[0]);

        //连接服务端
        if (!$client->connect($this->ip, $this->port, -1)) {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $client->send($data);
        return $client->recv();
        $client->close();

    }

    /**
     * 封装数据 json_rpc编码协议
     * @param $method
     * @param $params
     * @return false|string
     */
    private function jsonData($method,$params) {
        $req = [
            "jsonrpc"=> "2.0",
            "method"=> sprintf("%s::%s::%s",$this->version,$this->serviceName,$method),
            "params"=> $params
        ];
        return json_encode($req);
    }

}