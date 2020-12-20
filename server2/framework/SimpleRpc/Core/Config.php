<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/18
 * Time          : 2:08 下午
 */

namespace SimpleRpc\Core;


class Config
{
    private static $configMap=[];
    private static $instance;
    private function __construct() {
    }

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 加载配置
     */
    public function load() {
        $files = glob(CONFIG_PATH . '/*.php');

        if(!empty($files)) {
            foreach($files as $file) {
                self::$configMap += include $file;
            }
        }
        return $this;
    }

    /**
     * 获取配置
     * @param $key
     * @return bool
     */
    public function get($key) {
        return self::$configMap[$key] ?: false;
    }
}