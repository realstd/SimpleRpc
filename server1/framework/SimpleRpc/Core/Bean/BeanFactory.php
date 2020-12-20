<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/18
 * Time          : 11:00 上午
 */

namespace SimpleRpc\Core\Bean;

/**
 * IOC容器静态工厂
 * Class BeanFactory
 * @package SimpleRpc\Core\Bean
 */
class BeanFactory
{
    //IOC容器
    private static $container;

    public static function set(string $name, callable $function)
    {
        self::$container[self::initName($name)] = $function;
    }

    public static function get(string $name)
    {
        $name = self::initName($name);
        if(isset(self::$container[$name])) {
            return (self::$container[$name])();//执行容器中的方法
        }
    }

    private static function initName($name) {
        return strtolower($name);
    }
}