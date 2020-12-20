<?php

namespace SimpleRpc\Core\Route\Annotation\Mapping;

/**
 * 路由注解信息的路由收集
 * Class RequestMapping
 * @package SimpleRpc\Core\Route\Annotation\Mapping
 */
class RequestMapping
{
    /**
     * Action routing path
     *
     * @var string
     * @Required()
     */
    private $routePath = '';

    /**
     * @var string
     */
    private $prefix = '';

    private  $method;

    private  $handle;

    /**
     * RequestMapping constructor.
     * @param $classDocComment
     * @param $methodDocComment
     * @param $reflect
     * @param $method
     */
    public function __construct($classDocComment,$methodDocComment,$reflect,$method)
    {
        //获取类前缀
        $routePrefix =
            (new \SimpleRpc\Core\Route\Annotation\Mapping\Controller($classDocComment))->getPrefix();

        preg_match('/@RequestMapping\s*?\((.*)\)/i', $methodDocComment, $matchSurfix);
        $matchSurfix = explode(',', $matchSurfix[1]);
        $routeSurfix = trim(explode('=', $matchSurfix[0])[1], '"');

        //路由地址（类前缀+方法后缀）
        $this->routePath = sprintf("%s/%s", $routePrefix,$routeSurfix);

        //解析出来方法类型 GET / POST
        $this->method = strtoupper(trim(explode('=', $matchSurfix[1])[1], '"'));

        //转发处理的类
        $this->handle = sprintf("%s@%s", $reflect->getName(),$method->getName());
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->routePath;
    }

    /**
     * @return array
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getHandle(): string
    {
        return $this->handle;
    }
}
