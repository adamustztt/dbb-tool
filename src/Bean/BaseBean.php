<?php


namespace Tool\ShanTaoTool\Bean;




class BaseBean
{
    /**
     * 构造函数
     * @param $data 数据集
     */
    public function __construct($data = [])
    {
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                if (property_exists($this, $key) && !is_null($val)) {
                    $setMethodName = $this->getSetMethodName($key);
                    if (method_exists($this, $setMethodName)) {
                        $this->$setMethodName($val);
                    } else {
                        $this->$key = $val;
                    }
                }
            }
        }
    }

    /**
     * 获取set方法名称
     * @param $key
     * @return string
     */
    protected function getSetMethodName($key)
    {
        return "set" . ucfirst($key);
    }

    /**
     * 获取get方法名称
     * @param $key
     * @return string
     */
    protected function getGetMethodName($key)
    {
        return "get" . ucfirst($key);
    }

    public function toArray()
    {
        $data = [];
        //获取所有属性
        $reflectInstance = new \ReflectionClass(get_class($this));
        $properties = $reflectInstance->getProperties();
        foreach ($properties as $property){
            $key = $property->getName();
            $getMethodName = $this->getGetMethodName($key);
            $data[$key] = method_exists($this, $getMethodName) ? $this->$getMethodName() : $this->$key;
            if(is_null($data[$key])){
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * 下划线转驼峰
     * @param $key
     */
    public function conversionToTuoFeng($key)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $key);
        return $str;
    }

    /**
     * 驼峰转下划线
     * @param $key
     * @return string
     */
    public function conversionToXiaHuaXian($key)
    {
        $str = str_replace("_", "", $key);
        $str = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        return ltrim($str, "_");
    }
}