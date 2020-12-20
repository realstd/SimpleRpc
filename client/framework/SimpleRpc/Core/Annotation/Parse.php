<?php
/**
 * Author        : Tengda
 * Date          : 2020/12/18
 * Time          : 3:20 下午
 */

namespace SimpleRpc\Core\Annotation;

/**
 * 注解收集解析
 * Class Parse
 * @package SimpleRpc\Core
 */
class Parse
{
    /**
     * 解析注解
     * @throws \ReflectionException
     */
    public function loadAnnotations() {
        $dirs = $this->dirTree(APP_PATH,"Controller");
        if(!empty($dirs)) {
            foreach($dirs as $file) {
                //取出类名
                $className = explode('.',ltrim(strrchr($file,'/'),'/'))[0];
                $file=file_get_contents($file,false, null, 0,300);
                preg_match('/namespace\s(.*);/i', $file, $nameSpace);

                if(isset($nameSpace[1])) {
                    $className  = trim($nameSpace[1]) . "\\" . $className;
                    $obj        = new $className;
                    $reflect    = new \ReflectionClass($obj);
                    $classDocComment = $reflect->getDocComment();

                    //获取方法
                    foreach ($reflect->getMethods() as $method) {
                        //匹配方法注释获取路由中方法后缀
                        $methodDocComment = $method->getDocComment();

                        //收集注解信息-路由和操作类
                        $annotation = new \SimpleRpc\Core\Route\Annotation\Mapping\RequestMapping(
                            $classDocComment,$methodDocComment,$reflect,$method);
                        //路由注解格式解析
                        (new \SimpleRpc\Core\Route\Annotation\Parser\RequestMappingParser())->parse($annotation);
                    }
                }
            }
        }
    }

    /**
     * 遍历目录返回类文件
     * @param $dir
     * @param $filter
     * @return array|mixed
     */
    public  function  dirTree($dir,$filter){
        $dirs = glob($dir . '/*');
        $dirFiles=[];
        if(!empty($dirs)) {
            foreach ($dirs as $dir){
                if(is_dir($dir)){
                    $res=$this->dirTree($dir,$filter);
                    //防止数组层级太多
                    if(is_array($res)){
                        foreach ($res as $v){
                            $dirFiles[]=$v;
                        }
                    }
                }else{
                    //判断是否是需要筛选的文件
                    if(stristr($dir,$filter)){
                        $dirFiles[]=$dir;
                    }
                }
            }
        }
        return $dirFiles;
    }
}