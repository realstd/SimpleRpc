<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/18
 * Time          : 3:51 下午
 */

namespace SimpleRpc\Core;

/**
 * 热加载类
 * Class Reload
 * @package SimpleRpc\Core
 */
class Reload
{
    //需要监控重载的文件
    public $watchFile;
    //上次计算的文件md5值
    public $md5Flag;
    //单例
    private static $instance;
    private function __construct()
    {
    }
    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 判断是否需要重载(md5值改变)
     * @return bool
     */
    public function reload()
    {
        //当前文件的MD5的值跟上一次有没有区别
        $md5=$this->getMd5();
        if($md5 !=$this->md5Flag){
            $this->md5Flag=$md5; //重新赋值
            return true;
        }
        return false;
    }

    /**
     * 获取监控文件md5值
     * @return string
     */
    public function getMd5()
    {
        $md5 = '';
        foreach($this->watchFile as $dir) {
            $md5 .= self::md5File($dir);
        }
        return md5($md5);
    }

    /**
     * 获取目录md5值
     * @param $dir
     * @return string
     */
    public static function md5File($dir)
    {
        //遍历文件夹当中的所有文件,得到所有的文件的md5值
        if (!is_dir($dir)) {
            return '';
        }
        $md5File = array();
        $d = dir($dir);
        while (false !== ($entry = $d->read())) {
            if ($entry !== '.' && $entry !== '..') {
                if (is_dir($dir . '/' . $entry)) {
                    //递归调用
                    $md5File[] = self::md5File($dir . '/' . $entry);
                } elseif (substr($entry, -4) === '.php') {
                    $md5File[] = md5_file($dir . '/' . $entry);
                }
                $md5File[] = $entry;
            }
        }
        $d->close();
        return md5(implode('', $md5File));
    }
}