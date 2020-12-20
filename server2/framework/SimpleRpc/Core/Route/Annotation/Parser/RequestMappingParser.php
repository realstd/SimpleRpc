<?php

namespace SimpleRpc\Core\Route\Annotation\Parser;

use SimpleRpc\Core\Bean\BeanFactory;

/**
 * 注解信息解析
 * Class RequestMappingParser
 * @package SimpleRpc\Core\Route\Annotation\Parser
 */
class RequestMappingParser
{

    public function parse(\SimpleRpc\Core\Route\Annotation\Mapping\RequestMapping $annotation)
    {
        //route中的格式
        $routeRow = [
            'routePath' => $annotation->getRoute(),
            'handle' => $annotation->getHandle()
        ];
        //增加路由配置
        BeanFactory::get('route')->addRoute($annotation->getMethod(),$routeRow);
    }
}
