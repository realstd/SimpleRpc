<?php declare(strict_types=1);

namespace SimpleRpc\Core\Route\Annotation\Mapping;

/**
 * 类注解信息的路由收集
 * Class Controller
 * @package SimpleRpc\Core\Route\Annotation\Mapping
 */
final class Controller
{
    /**
     * Route group prefix for the controller
     *
     * @Required()
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Controller constructor.
     * @param $classDocComment
     */
    public function __construct($classDocComment)
    {
        //类注解信息的路由收集
        preg_match('/@Controller\s*?\((.*)\)/i', $classDocComment, $routePrefix);
        $routePrefix = trim(explode('=', $routePrefix[1])[1], '"');
        strpos($routePrefix, '/') === false && $routePrefix = '/' . $routePrefix;

        $this->prefix = $routePrefix; //清除掉引号
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}